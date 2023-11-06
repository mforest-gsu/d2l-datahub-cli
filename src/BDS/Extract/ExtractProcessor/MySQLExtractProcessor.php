<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractProcessor;

use D2L\DataHub\BDS\Extract\ExtractProcessor\ExtractProcessor;
use D2L\DataHub\BDS\Extract\Model\BDSExtractProcessInfo;
use D2L\DataHub\BDS\Extract\Model\BDSProcessInfo;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\Utils\FileIO;

class MySQLExtractProcessor extends ExtractProcessor
{
    /** @var int */
    protected const BUFFER_SIZE = 10000;


    /**
     * @inheritdoc
     */
    protected function processFullDiff(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array {
        return $this->generateDataFile(
            processInfo: $processInfo,
            csvFile: $csvFile,
            globalHeader: "TRUNCATE TABLE `{$processInfo->tableName}_LOAD`;",
            chunkHeader: implode("\n", [
                "INSERT IGNORE INTO `{$processInfo->tableName}_LOAD`",
                "  (",
                implode(",\n", array_map(fn ($c) => "    `{$c->name}`", $processInfo->columns)),
                "  )",
                "VALUES"
            ]),
            chunkFooter: ";",
            globalFooter: implode("\n", [
                "DELETE FROM",
                "  `{$processInfo->tableName}` t",
                "WHERE",
                "  EXISTS(",
                "    SELECT",
                "      1",
                "    FROM",
                "      `{$processInfo->tableName}_LOAD` s",
                "    WHERE",
                implode(" AND\n", array_map(
                    fn ($c) => "      s.{$c->name} = t.{$c->name}",
                    array_filter($processInfo->columns, fn ($c) => $c->pk)
                )),
                "  )",
                ";",
            ]),
        );
    }


    /**
     * @inheritdoc
     */
    protected function processFull(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array {
        return $this->generateDataFile(
            processInfo: $processInfo,
            csvFile: $csvFile,
            globalHeader: implode("\n", [
                "TRUNCATE TABLE `{$processInfo->tableName}`;"
            ]),
            chunkHeader: implode("\n", [
                "INSERT IGNORE INTO `{$processInfo->tableName}`",
                "  (",
                implode(",\n", array_map(fn ($c) => "    `{$c->name}`", $processInfo->columns)),
                "  )",
                "VALUES"
            ]),
            chunkFooter: ";"
        );
    }


    /**
     * @inheritdoc
     */
    protected function processDiff(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array {
        return $this->generateDataFile(
            processInfo: $processInfo,
            csvFile: $csvFile,
            chunkHeader: implode("\n", [
                "INSERT INTO `{$processInfo->tableName}`",
                "  (",
                implode(",\n", array_map(
                    fn ($c) => "    `{$c->name}`",
                    $processInfo->columns
                )),
                "  )",
                "VALUES"
            ]),
            chunkFooter: implode("\n", [
                "AS new ON DUPLICATE KEY UPDATE",
                implode(",\n", array_map(
                    fn ($c) =>  "  `{$c->name}`=new.`{$c->name}`",
                    $processInfo->columns
                )) . "\n",
                ";"
            ])
        );
    }


    /**
     * @inheritdoc
     */
    protected function getFormatter(
        BDSExtractProcessInfo $processInfo,
        BDSSchemaColumn $column
    ): \Closure {
        return match ($column->dataType) {
            'bit' => fn ($v) => ($v === '')
                ? 'NULL'
                : match (strtoupper($v)) {
                    "1", "T", "TRUE" => "1",
                    default => "0"
                },
            'float' => fn ($v) => ($v === '')
                ? 'NULL'
                : strval(floatval($v)),
            'bigint', 'int', 'smallint' => fn ($v) => ($v === '')
                ? 'NULL'
                : strval(intval($v)),
            'datetime2' => function ($v): string {
                $dateValue = ($v !== '') ? @strtotime($v) : false;
                return is_int($dateValue) ? "'" . date('Y-m-d H:i:s', $dateValue) . "'" : 'NULL';
            },
            'nvarchar', 'varchar' => fn ($v) => ($v === '')
                ? 'NULL'
                : "'" . preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', $v) . "'",
            default => fn ($v) => $v === ''
                ? 'NULL'
                : "'{$v}'",
        };
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @param resource $csvFile
     * @param string $globalHeader
     * @param string $chunkHeader
     * @param string $chunkFooter
     * @param string $globalFooter
     * @return array{0:int,1:array<string,string>}
     */
    protected function generateDataFile(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile,
        string $globalHeader = "",
        string $chunkHeader = "",
        string $chunkFooter = "",
        string $globalFooter = ""
    ): array {
        $totalRows = 0;
        $dataFilePath = "{$this->options->processDir}/{$processInfo->extractName}.sql.gz";

        $globalHeader = ($globalHeader !== '') ? "{$globalHeader}\n" : "";
        $chunkHeader = "{$chunkHeader}\n";
        $rowEnd = ",\n";
        $chunkFooter = "\n{$chunkFooter}\n";
        $globalFooter = ($globalFooter !== '') ? "\n{$globalFooter}\n" : "";

        try {
            // Open output data file
            $dataFile = FileIO::openGzipFile($dataFilePath);

            // Write global header, if it's set
            if ($globalHeader !== '') {
                gzwrite($dataFile, $globalHeader . "\n");
            }

            // For each row in extract
            for ($rowNum = 1; $row = fgetcsv(stream: $csvFile, escape: '"'); $rowNum++) {
                // If at end of current chunk
                if ($totalRows % self::BUFFER_SIZE === 0) {
                    // Close out previous chunk, if it exists
                    if ($totalRows > 0) {
                        gzwrite($dataFile, $chunkFooter);
                    }
                    // Start new chunk
                    gzwrite($dataFile, $chunkHeader);
                } else {
                    // End previous row
                    gzwrite($dataFile, $rowEnd);
                }

                // Write current row
                foreach ($row as $i => $v) {
                    try {
                        $row[$i] = ($processInfo->formatters[$i])($v);
                    } catch (\Throwable $t) {
                        throw new \RuntimeException(
                            "Unable to format row '{$rowNum}', col '{$i}'",
                            0,
                            $t
                        );
                    }
                }

                try {
                    gzwrite($dataFile, "  (" . implode(",", $row) . ")");
                } catch (\Throwable $t) {
                    throw new \RuntimeException(
                        "Unable to write row '{$rowNum}'",
                        0,
                        $t
                    );
                }

                $totalRows++;
            }

            // Close out last chunk, if it exists
            if ($totalRows > 0) {
                gzwrite($dataFile, $chunkFooter);
            }

            // Write global footer, if it's set
            if ($globalFooter !== '') {
                gzwrite($dataFile, $globalFooter . "\n");
            }
        } finally {
            // Close output data file
            if (is_resource($dataFile ?? null)) {
                @gzclose($dataFile);
            }
            unset($dataFile);
        }

        return [$totalRows, ['data' => $dataFilePath]];
    }
}

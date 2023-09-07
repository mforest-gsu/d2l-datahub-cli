<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractProcessor;

use D2L\DataHub\BDS\Extract\ExtractProcessor;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use RuntimeException;

class MySQLExtractProcessor extends ExtractProcessor
{
    public static string $processFileExtension = '.sql.gz';


    /**
     * @param BDSSchema $schema
     * @param string $bdsType
     * @param string $extractName
     * @param string $extractPath
     * @return int
     */
    public function processExtract(
        BDSSchema $schema,
        string $bdsType,
        string $extractName,
        string $extractPath
    ): int {
        $error = false;
        $total = 0;
        $bufferSize = 10000;
        $processPath = $this->getProcessPath($extractName);
        $tableName = $this->getTableName($schema);

        try {
            // Open input and output files
            list($zipFile, $extractFile) = $this->openExtractFile($extractPath);
            $processFile = $this->openProcessFile($processPath);

            // Read first line in file and map column positions to dataset fields
            $columns = $this->getColumns($schema, $extractFile);

            $header = $this->getHeader($tableName, $columns);
            $footer = $this->getFooter($columns);
            $formatters = $this->getColumnFormatters($columns);
            $rowEnd = ",\n  ";

            if ($bdsType === 'Full') {
                gzwrite($processFile, "TRUNCATE `{$tableName}`;\n\n");
            }

            // For each row in extract
            while ($row = fgetcsv(stream: $extractFile, escape: '"')) {
                if ($total % $bufferSize === 0) {
                    if ($total > 0) {
                        gzwrite($processFile, $footer);
                    }
                    gzwrite($processFile, $header);
                } else {
                    gzwrite($processFile, $rowEnd);
                }

                foreach ($row as $i => $v) {
                    $row[$i] = ($formatters[$i])($v);
                }
                gzwrite($processFile, "(" . implode(",", $row) . ")");

                $total++;
            }

            if ($total > 0) {
                gzwrite($processFile, $footer);
            }
        } catch (\Throwable $t) {
            $error = true;
            throw new RuntimeException("Error processing {$extractPath}", 0, $t);
        } finally {
            // Close extract file
            if (is_resource($extractFile ?? null)) {
                @fclose($extractFile);
            }
            if (($zipFile ?? null) instanceof \ZipArchive) {
                @$zipFile->close();
            }

            // Close process file
            if (is_resource($processFile ?? null)) {
                @gzclose($processFile);
            }

            unset($zipFile, $extractFile, $processFile);

            if ($error === true) {
                // Remove process file if there was an error
                @unlink($processPath);
            } elseif ($total < 1) {
                // Create zero byte file if there are no records to process
                @unlink($processPath);
                @touch($processPath);
            }
        }

        return $total;
    }


    /**
     * @param string $tableName
     * @param array<int,BDSSchemaColumn> $columns
     * @return string
     */
    private function getHeader(
        string $tableName,
        array &$columns
    ): string {
        $columnNames = implode(", ", array_map(fn ($column) => "`{$column->name}`", $columns));

        return ""
            . "INSERT INTO `{$tableName}`\n"
            . "  ({$columnNames})\n"
            . "VALUES\n"
            . "  ";
    }


    /**
     * @param array<int,BDSSchemaColumn> $columns
     * @return string
     */
    private function getFooter(array &$columns): string
    {
        $columnAssignments = implode(
            ",\n",
            array_map(
                fn ($column) =>  "  `{$column->name}`=new.`{$column->name}`",
                $columns
            )
        );

        return ""
            . "\n"
            . "AS new ON DUPLICATE KEY UPDATE\n"
            . $columnAssignments
            . "\n;"
            . "\n";
    }


    /**
     * @param array<int,BDSSchemaColumn> $columns
     * @return array<int,(callable(string $v): string)>
     */
    private function getColumnFormatters(array &$columns): array
    {
        return array_map(
            fn ($column) => $column->canBeNull
                ? match (strtoupper($column->dataType)) {
                    'BIGINT', 'INT', 'FLOAT', 'DECIMAL' => fn (string $v): string => $v === ''
                        ? 'NULL'
                        : $this->formatNumeric($v),
                    'BIT' => fn (string $v): string => $v === '' ? 'NULL' : $this->formatBoolean($v),
                    'DATETIME2' => fn (string $v): string => $v === '' ? 'NULL' : $this->formatDatetime($v),
                    default => fn (string $v): string => $v === '' ? 'NULL' : $this->formatString($v),
                }
                : match (strtoupper($column->dataType)) {
                    'BIGINT', 'INT', 'FLOAT', 'DECIMAL' => fn (string $v): string => $this->formatNumeric($v),
                    'BIT' => fn (string $v): string => $this->formatBoolean($v),
                    'DATETIME2' => fn (string $v): string => $this->formatDatetime($v),
                    default => fn (string $v): string => $this->formatString($v),
                },
            $columns
        );
    }


    /**
     * @param string $v
     * @return string
     */
    private function formatNumeric(string $v): string
    {
        return "'{$v}'";
    }


    /**
     * @param string $v
     * @return string
     */
    private function formatBoolean(string $v): string
    {
        return match (strtoupper($v)) {
            "1", "T", "TRUE", "Y", "YES" => "'1'",
            default => "'0'"
        };
    }


    /**
     * @param string $v
     * @return string
     */
    private function formatDatetime(string $v): string
    {
        $dateValue = @strtotime($v);
        return is_int($dateValue) ? date('Y-m-d H:i:s', $dateValue) : throw new \RuntimeException();
    }


    /**
     * @param string $v
     * @return string
     */
    private function formatString(string $v): string
    {
        return "'" . preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', $v) . "'";
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractProcessor;

use D2L\DataHub\BDS\Extract\ExtractProcessor\ExtractProcessor;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Extract\Model\BDSExtractProcessInfo;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaNameMap;
use D2L\DataHub\Utils\FileIO;

class OracleExtractProcessor extends ExtractProcessor
{
    /** @var array<string,string> */
    private const SPECIAL_CHARS = [
        "\xC2\xAB" => "<<",
        "\xC2\xBB" => ">>",
        "\xE2\x80\x98" => "'",
        "\xE2\x80\x99" => "'",
        "\xE2\x80\x9A" => "'",
        "\xE2\x80\x9B" => "'",
        "\xE2\x80\x9C" => '"',
        "\xE2\x80\x9D" => '"',
        "\xE2\x80\x9E" => '"',
        "\xE2\x80\x9F" => '"',
        "\xE2\x80\xB9" => "<",
        "\xE2\x80\xBA" => ">",
        "\xE2\x80\x93" => "-",
        "\xE2\x80\x94" => "-",
        "\xE2\x80\xA6" => "...",
        "\t" => " ",
        "\r" => " ",
        "\n" => " ",
    ];

    /** @var array<string> $search */
    private array $search;

    /** @var array<string> $replacements */
    private array $replacements;


    /**
     * @inheritdoc
     */
    public function __construct(
        protected BDSExtractOptions $options,
        protected BDSSchemaNameMap $nameMap
    ) {
        parent::__construct($options, $nameMap);
        $this->search = array_keys(self::SPECIAL_CHARS);
        $this->replacements = array_values(self::SPECIAL_CHARS);
    }


    /**
     * @inheritdoc
     */
    protected function processFullDiff(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array {
        return $this->generateProcessFiles(
            $processInfo,
            $csvFile,
            [
                "DELETE FROM",
                "  {$processInfo->tableName} t",
                "WHERE",
                "  EXISTS(",
                "    SELECT",
                "      1",
                "    FROM",
                "      {$processInfo->tableName}_LOAD s",
                "    WHERE",
                implode(" AND\n", array_map(
                    fn ($col) => "      s.{$col} = t.{$col}",
                    array_map(
                        fn ($c) => $this->getTableColumnName($c->name),
                        $processInfo->columns
                    )
                )),
                "  )",
                ";",
            ]
        );
    }


    /**
     * @inheritdoc
     */
    protected function processFull(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array {
        return $this->generateProcessFiles(
            $processInfo,
            $csvFile,
            ["TRUNCATE TABLE {$processInfo->tableName}_LOAD"]
        );
    }


    /**
     * @inheritdoc
     */
    protected function processDiff(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array {
        return $this->generateProcessFiles(
            $processInfo,
            $csvFile,
            [
                "MERGE INTO {$processInfo->tableName} t",
                "USING {$processInfo->tableName}_LOAD s",
                "ON (",
                implode(" AND\n", array_map(
                    fn ($col) => "  t.{$col} = s.{$col}",
                    array_map(
                        fn ($col) => self::getTableColumnName($col->name),
                        array_filter(
                            $processInfo->columns,
                            fn ($col) => $col->pk
                        )
                    )
                )),
                ")",
                ...(function ($nonKeyFields) {
                    return (count($nonKeyFields) > 0)
                        ? [
                            "WHEN MATCHED THEN UPDATE SET",
                            implode(",\n", array_map(
                                fn ($c) => "  t.{$c} = s.{$c}",
                                array_map(
                                    fn ($c) => $this->getTableColumnName($c->name),
                                    $nonKeyFields
                                )
                            ))
                        ]
                        : [];
                })(array_filter($processInfo->columns, fn ($c) => !$c->pk)),
                "WHEN NOT MATCHED THEN",
                "INSERT (",
                implode(",\n", array_map(
                    fn ($c) => "  t." . $this->getTableColumnName($c->name),
                    $processInfo->columns
                )),
                ")",
                "VALUES (",
                implode(",\n", array_map(
                    fn ($c) => "  s." . $this->getTableColumnName($c->name),
                    $processInfo->columns
                )),
                ");"
            ]
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
                ? ''
                : match (strtoupper($v)) {
                    "1", "T", "TRUE" => "1",
                    default => "0"
                },
            'float' => fn ($v) => ($v === '')
                ? ''
                : strval(floatval($v)),
            'bigint', 'int', 'smallint' => fn ($v) => ($v === '')
                ? ''
                : strval(intval($v)),
            'nvarchar', 'varchar' => fn ($v) => ($v === '')
                ? ''
                : substr(
                    str_replace($this->search, $this->replacements, $v),
                    0,
                    min(intval(2 * max(1, intval($column->columnSize))), 4000)
                ),
            default => fn ($v) => $v,
        };
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @param resource $csvFile
     * @param string[] $sql
     * @return array{0:int,1:array<string,string>}
     */
    protected function generateProcessFiles(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile,
        array $sql
    ): array {
        list($totalRows, $dataFilePath) = $this->generateDataFile($processInfo, $csvFile);
        $ctlFilePath = $this->generateCtlFile($processInfo);
        $sqlFilePath = $this->generateSqlFile($processInfo, $sql);

        return [
            $totalRows,
            [
                'data' => $dataFilePath,
                'ctl' => $ctlFilePath,
                'sql' => $sqlFilePath
            ]
        ];
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @param resource $csvFile
     * @return array{0:int,1:string}
     */
    protected function generateDataFile(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array {
        $totalRows = 0;
        $dataFilePath = "{$this->options->processDir}/{$processInfo->extractName}.dat.gz";

        try {
            // Open output data file
            $dataFile = FileIO::openGzipFile($dataFilePath);

            // For each row in extract
            for ($rowNum = 1; $row = fgetcsv(stream: $csvFile, escape: '"'); $rowNum++) {
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
                    fputcsv($dataFile, $row, ",", "\"", "", "\n");
                } catch (\Throwable $t) {
                    throw new \RuntimeException(
                        "Unable to write row '{$rowNum}'",
                        0,
                        $t
                    );
                }

                $totalRows++;
            }
        } finally {
            // Close output data file
            if (is_resource($dataFile ?? null)) {
                @gzclose($dataFile);
            }
            unset($dataFile);
        }

        return [$totalRows, $dataFilePath];
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @return string
     */
    protected function generateCtlFile(BDSExtractProcessInfo $processInfo): string
    {
        $ctlFilePath = "{$this->options->processDir}/{$processInfo->extractName}.ctl";
        $tableName = ($processInfo->bdsType === 'Full')
            ? $processInfo->tableName
            : $processInfo->tableName . '_LOAD';

        FileIO::putContents(
            $ctlFilePath,
            [
                "UNRECOVERABLE",
                "LOAD DATA",
                "CHARACTERSET UTF8",
                "TRUNCATE INTO TABLE {$tableName}",
                "FIELDS TERMINATED BY \",\"",
                "OPTIONALLY ENCLOSED BY '\"'",
                "TRAILING NULLCOLS",
                "(",
                implode(",\n", array_map(fn ($c) => $this->getCtlColumn($c), $processInfo->columns)),
                ")",
            ]
        );

        return $ctlFilePath;
    }


    /**
     * @param BDSSchemaColumn $column
     * @return string
     */
    protected function getCtlColumn(BDSSchemaColumn $column): string
    {
        $name = $this->getTableColumnName($column->name);

        $columnSize = max(match ($column->dataType) {
            'bigint' => 20,
            'bit' => 1,
            'datetime2' => 21,
            'decimal' => intval(array_sum(explode(",", $column->columnSize))),
            'float' => 126,
            'int' => 10,
            'nvarchar', 'varchar' => intval(2.5 * intval($column->columnSize)),
            'smallint' => 5,
            'uniqueidentifier' => 36,
            default => intval($column->columnSize)
        }, 1);

        $dataType = match ($column->dataType) {
            'bigint', 'bit', 'int', 'smallint' => "INTEGER EXTERNAL({$columnSize})",
            'datetime2' => "TIMESTAMP WITH TIME ZONE 'yyyy-mm-dd\"T\"hh24:mi:ss.fftzhtzm'",
            'decimal' => "DECIMAL EXTERNAL({$columnSize})",
            'float' => "FLOAT EXTERNAL({$columnSize})",
            'nvarchar', 'varchar', 'uniqueidentifier' => "CHAR({$columnSize})",
            default => "CHAR({$columnSize})"
        };

        return implode(
            " ",
            ($column->canBeNull)
                ? [" ", $name, $dataType, "NULLIF ({$name}=BLANKS)"]
                : [" ", $name, $dataType]
        );
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @param string[] $sql
     * @return string
     */
    protected function generateSqlFile(
        BDSExtractProcessInfo $processInfo,
        array $sql
    ): string {
        $sqlFilePath = "{$this->options->processDir}/{$processInfo->extractName}.sql";
        array_push($sql, "", "QUIT;");
        FileIO::putContents($sqlFilePath, $sql);
        return $sqlFilePath;
    }


    /**
     * @param string $name
     * @return string
     */
    protected function getTableColumnName(string $name): string
    {
        return match (strtolower($name)) {
            "group", "comment", "order" => "D2L" . $name,
            default => $name
        };
    }
}

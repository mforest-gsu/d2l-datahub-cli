<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractProcessor;

use D2L\DataHub\BDS\Extract\ExtractProcessor;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaNameMap;
use RuntimeException;

class OracleExtractProcessor extends ExtractProcessor
{
    public static string $processFileExtension = '.dat.gz';

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
     * @param BDSExtractOptions $options
     * @param BDSSchemaNameMap $nameMap
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
        $tableName = $this->getTableName($schema);

        $columns = [];
        $rows = $this->generateCSVFile(
            $schema,
            $extractName,
            $extractPath,
            $columns
        );

        if ($rows > 0) {
            $this->generateParFile($extractName);
            $this->generateCtlFile($extractName, $columns, $tableName, $bdsType);
            $this->generateSQLFile($extractName, $columns, $tableName, $bdsType);
        }

        return $rows;
    }


    /**
     * @param BDSSchema $schema
     * @param string $extractName
     * @param string $extractPath
     * @param array<int,BDSSchemaColumn> $columns
     * @return int
     */
    private function generateCSVFile(
        BDSSchema $schema,
        string $extractName,
        string $extractPath,
        array &$columns
    ): int {
        $error = false;
        $total = 0;
        $datPath = $this->getProcessPath($extractName);

        try {
            // Open input and output files
            list($zipFile, $extractFile) = $this->openExtractFile($extractPath);
            $datFile = $this->openProcessFile($datPath);

            // Read first line in file and map column positions to dataset fields
            $columns = $this->getColumns($schema, $extractFile);
            $formatters = $this->getColumnFormatters($columns);

            // For each row in extract
            while ($row = fgetcsv(stream: $extractFile, escape: '"')) {
                foreach ($row as $i => $v) {
                    $row[$i] = ($formatters[$i])($v);
                }
                fputcsv($datFile, $row, ",", "\"", "", "\n");
                $total++;
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
            if (is_resource($datFile ?? null)) {
                @gzclose($datFile);
            }

            unset($zipFile, $extractFile, $datFile);

            if ($error === true) {
                // Remove process file if there was an error
                @unlink($datPath);
            }
        }

        return $total;
    }


    /**
     * @param string $extractName
     * @return void
     */
    private function generateParFile(string $extractName): void
    {
        $bytes = file_put_contents(
            $this->getProcessPath($extractName, '.par'),
            implode("\n", [
                "direct=true",
                "control=" . $this->getProcessPath($extractName, '.ctl'),
                "log={$this->options->uploadsDir}/{$extractName}.txt",
                "bad={$this->options->uploadsDir}/{$extractName}.bad.txt",
                "discard={$this->options->uploadsDir}/{$extractName}.discard.txt",
                "errors=0",
                "date_cache=0",
            ])
        );

        if ($bytes === false) {
            throw new \RuntimeException();
        }
    }


    /**
     * @param string $extractName
     * @param array<int,BDSSchemaColumn> $columns
     * @param string $tableName
     * @param string $bdsType
     * @return void
     */
    private function generateCtlFile(
        string $extractName,
        array &$columns,
        string $tableName,
        string $bdsType
    ): void {
        if ($bdsType !== 'Full') {
            $tableName .= '_LOAD';
        }

        $fields = implode(",\n", array_map(
            function (BDSSchemaColumn $column): string {
                /** @var int $columnSize */
                $columnSize = max(match ($column->dataType) {
                    'datetime2' => 21,
                    'bigint' => 20,
                    'int' => 10,
                    'bit' => 1,
                    'decimal' => intval(
                        array_sum(
                            explode(",", $column->columnSize)
                        )
                    ),
                    default => intval(2.5 * intval($column->columnSize))
                }, 1);

                $name = $this->getColumnName($column->name);
                $dataType = match ($column->dataType) {
                    'datetime2' => "DATE \"YYYY-MM-DD HH24:MI:SS\"",
                    'bigint' => "INTEGER EXTERNAL({$columnSize})",
                    'int' => "INTEGER EXTERNAL({$columnSize})",
                    'bit' => "INTEGER EXTERNAL({$columnSize})",
                    'decimal' => "DECIMAL EXTERNAL({$columnSize})",
                    'float' => "FLOAT EXTERNAL({$columnSize})",
                    default => "CHAR({$column->columnSize})"
                };

                $row = [" ", $name, $dataType];
                if ($column->canBeNull) {
                    $row[] = "NULLIF ({$name}=BLANKS)";
                }

                return implode(" ", $row);
            },
            $columns
        ));

        $bytes = file_put_contents(
            $this->getProcessPath($extractName, '.ctl'),
            implode("\n", [
                "LOAD DATA",
                "CHARACTERSET UTF8",
                "INFILE \"" . $this->getProcessPath($extractName, '.dat') . "\"",
                "TRUNCATE INTO TABLE {$tableName}",
                "FIELDS TERMINATED BY \",\"",
                "OPTIONALLY ENCLOSED BY '\"'",
                "TRAILING NULLCOLS",
                "(",
                $fields,
                ")"
            ])
        );

        if ($bytes === false) {
            throw new \RuntimeException();
        }
    }


    /**
     * @param string $extractName
     * @param array<int,BDSSchemaColumn> $columns
     * @param string $tableName
     * @param string $bdsType
     * @return void
     */
    protected function generateSQLFile(
        string $extractName,
        array &$columns,
        string $tableName,
        string $bdsType
    ): void {
        $sql = [];

        if ($bdsType === 'Full') {
            array_push($sql, "TRUNCATE TABLE {$tableName}_LOAD;");
        } else {
            $keys = array_filter($columns, fn ($col) => $col->pk);
            $notKeys = array_filter($columns, fn ($col) => !$col->pk);

            array_push(
                $sql,
                "MERGE INTO {$tableName} t",
                "USING {$tableName}_LOAD s",
                "ON (",
                implode(" AND\n", array_map(
                    fn ($col) => "  t.{$col} = s.{$col}",
                    array_map(
                        fn ($col) => $this->getColumnName($col->name),
                        $keys
                    )
                )),
                ")",
            );

            if (count($notKeys) > 0) {
                array_push(
                    $sql,
                    "WHEN MATCHED THEN UPDATE SET",
                    implode(",\n", array_map(
                        fn ($col) => "  t.{$col} = s.{$col}",
                        array_map(
                            fn ($col) => $this->getColumnName($col->name),
                            array_filter(
                                $columns,
                                fn ($col) => !$col->pk
                            )
                        )
                    )),
                );
            }

            array_push(
                $sql,
                "WHEN NOT MATCHED THEN",
                "INSERT (",
                implode(",\n", array_map(
                    fn ($col) => "  t." . $this->getColumnName($col->name),
                    $columns
                )),
                ")",
                "VALUES (",
                implode(",\n", array_map(
                    fn ($col) => "  s." . $this->getColumnName($col->name),
                    $columns
                )),
                ");"
            );
        }

        array_push($sql, "", "QUIT;");

        $bytes = file_put_contents(
            $this->getProcessPath($extractName, '.sql'),
            implode("\n", $sql) . "\n"
        );

        if ($bytes === false) {
            throw new \RuntimeException();
        }
    }


    /**
     * @param string $name
     * @return string
     */
    private function getColumnName(string $name): string
    {
        return match (strtolower($name)) {
            "group", "comment", "order" => "D2L" . $name,
            default => $name
        };
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
                    'BIGINT', 'INT', 'FLOAT', 'DECIMAL' => fn (string $v): string => $v,
                    'BIT' => fn (string $v): string => $v !== '' ? $this->formatBoolean($v) : '',
                    'DATETIME2' => fn (string $v): string => $v !== '' ? $this->formatDatetime($v) : '',
                    default => fn (string $v): string => $v !== '' ? $this->formatString($v) : '',
                }
                : match (strtoupper($column->dataType)) {
                    'BIGINT', 'INT', 'FLOAT', 'DECIMAL' => fn (string $v): string => $v !== '' ? $v : '0',
                    'BIT' => fn (string $v): string => $v !== '' ? $this->formatBoolean($v) : '0',
                    'DATETIME2' => fn (string $v): string => $v !== '' ? $this->formatDatetime($v)
                        : throw new \RuntimeException(),
                    default => fn (string $v): string => $v !== '' ? $this->formatString($v) : chr(0),
                },
            $columns
        );
    }


    /**
     * @param string $v
     * @return string
     */
    private function formatBoolean(string $v): string
    {
        return match (strtoupper($v)) {
            "1", "T", "TRUE", "Y", "YES" => "1",
            default => "0"
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
        return str_replace($this->search, $this->replacements, $v);
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractProcessor;

use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\Utils\FileIO;

class OracleLoaderFileGenerator
{
    /**
     * @param string $control
     * @param string $log
     * @param string $bad
     * @param string $discard
     * @param int $errors
     * @param int $dateCache
     * @return void
     */
    public static function generateParFile(
        string $parPath,
        string $control,
        string $log,
        string $bad,
        string $discard,
        int $errors = 10000,
        int $dateCache = 0
    ): void {
        FileIO::putContents($parPath, [
            "direct=true",
            "control={$control}",
            "log={$log}",
            "bad={$bad}",
            "discard={$discard}",
            "errors={$errors}",
            "date_cache={$dateCache}",
        ]);
    }


    /**
     * @param string $ctlPath
     * @param string $datPath
     * @param string $tableName
     * @param BDSSchemaColumn[] $columns
     * @return void
     */
    public static function generateCtlFile(
        string $ctlPath,
        string $datPath,
        string $tableName,
        array $columns
    ): void {
        FileIO::putContents($ctlPath, [
            "LOAD DATA",
            "CHARACTERSET UTF8",
            "INFILE \"{$datPath}\"",
            "TRUNCATE INTO TABLE {$tableName}",
            "FIELDS TERMINATED BY \",\"",
            "OPTIONALLY ENCLOSED BY '\"'",
            "TRAILING NULLCOLS",
            "(",
            implode(",\n", array_map(
                fn (BDSSchemaColumn $column): string => self::getCtlColumn($column),
                $columns
            )),
            ")",
        ]);
    }


    /**
     * @param string $sqlPath
     * @param string $bdsType
     * @param string $loadTable
     * @param string $dataTable
     * @param BDSSchemaColumn[] $columns
     * @return void
     */
    public static function generateSqlFile(
        string $sqlPath,
        string $bdsType,
        string $loadTable,
        string $dataTable,
        array $columns
    ): void {
        if ($bdsType === 'Full') {
            $sql = ["TRUNCATE TABLE {$loadTable}"];
        } else {
            $nonKeyFields = array_filter($columns, fn ($col) => !$col->pk);
            if (count($nonKeyFields) > 0) {
                $nonKeyFields = [
                    "WHEN MATCHED THEN UPDATE SET",
                    implode(",\n", array_map(
                        fn ($col) => "  t.{$col} = s.{$col}",
                        array_map(
                            fn ($col) => self::getColumnName($col->name),
                            $nonKeyFields
                        )
                    ))
                ];
            }

            $sql = [
                "MERGE INTO {$dataTable} t",
                "USING {$loadTable} s",
                "ON (",
                implode(" AND\n", array_map(
                    fn ($col) => "  t.{$col} = s.{$col}",
                    array_map(
                        fn ($col) => self::getColumnName($col->name),
                        array_filter($columns, fn ($col) => $col->pk)
                    )
                )),
                ")",
                ...$nonKeyFields,
                "WHEN NOT MATCHED THEN",
                "INSERT (",
                implode(",\n", array_map(fn ($col) => "  t." . self::getColumnName($col->name), $columns)),
                ")",
                "VALUES (",
                implode(",\n", array_map(fn ($col) => "  s." . self::getColumnName($col->name), $columns)),
                ");"
            ];
        }

        $sql[] = "\nQUIT;";

        FileIO::putContents($sqlPath, $sql);
    }


    /**
     * @param string $name
     * @return string
     */
    private static function getColumnName(string $name): string
    {
        return match (strtolower($name)) {
            "group", "comment", "order" => "D2L" . $name,
            default => $name
        };
    }


    /**
     * @param BDSSchemaColumn $column
     * @return string
     */
    private static function getCtlColumn(BDSSchemaColumn $column): string
    {
        $name = self::getColumnName($column->name);
        $dataType = self::getCtlDataType($column->dataType, $column->columnSize);
        return implode(
            " ",
            ($column->canBeNull)
                ? [" ", $name, $dataType, "NULLIF ({$name}=BLANKS)"]
                : [" ", $name, $dataType]
        );
    }


    /**
     * @param string $dataType
     * @param string $columnSize
     * @return string
     */
    private static function getCtlDataType(
        string $dataType,
        string $columnSize
    ): string {
        $columnSize = max(match ($dataType) {
            'bigint' => 20,
            'bit' => 1,
            'datetime2' => 21,
            'decimal' => intval(array_sum(explode(",", $columnSize))),
            'float' => 126,
            'int' => 10,
            'nvarchar', 'varchar' => intval(2.5 * intval($columnSize)),
            'smallint' => 5,
            'uniqueidentifier' => 36,
            default => intval($columnSize)
        }, 1);

        return match ($dataType) {
            'bigint', 'bit', 'int', 'smallint' => "INTEGER EXTERNAL({$columnSize})",
            'datetime2' => "TIMESTAMP WITH TIME ZONE 'yyyy-mm-dd\"T\"hh24:mi:ss.fftzhtzm'",
            'decimal' => "DECIMAL EXTERNAL({$columnSize})",
            'float' => "FLOAT EXTERNAL({$columnSize})",
            'nvarchar', 'varchar', 'uniqueidentifier' => "CHAR({$columnSize})",
            default => "CHAR({$columnSize})"
        };
    }
}

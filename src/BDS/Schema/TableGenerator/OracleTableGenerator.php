<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\TableGenerator;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;

class OracleTableGenerator extends TableGenerator
{
    /**
     * @param BDSSchema $dataset
     * @return int
     */
    public function generate(BDSSchema $dataset): int
    {
        $tableName = $this->getTableName($dataset);

        return
            $this->saveTable(
                $tableName,
                $this->generateTable($dataset, $tableName)
            ) + $this->saveTable(
                $tableName . '_LOAD',
                $this->generateTable($dataset, $tableName . '_LOAD')
            );
    }


    /**
     * @param BDSSchema $dataset
     * @param string $tableName
     * @return string
     */
    protected function generateTable(
        BDSSchema $dataset,
        string $tableName
    ): string {
        list($tableCols, $indexCols) = $this->renderTableColumns($dataset);
        if ($indexCols !== '') {
            $indexCols = "CREATE UNIQUE INDEX {$tableName}_PK ON {$tableName} ({$indexCols});\n";
        }

        return ""
            . "DROP TABLE {$tableName};\n"
            . "CREATE TABLE {$tableName} (\n"
            . "  {$tableCols}\n"
            . ");\n"
            . "{$indexCols}"
            . "QUIT;";
    }


    /**
     * @param BDSSchema $dataset
     * @return array{0:string, 1:string}
     */
    private function renderTableColumns(BDSSchema $dataset): array
    {
        $columns = [];
        $primaryKeys = [];

        foreach ($dataset->columns as $column) {
            $columnName = match (strtolower($column->name)) {
                "group", "comment", "order" => "D2L" . $column->name,
                default => $column->name
            };
            $dataType = $this->getDataType($column);
            //$canBeNull = $column->canBeNull ? "DEFAULT NULL" : "NOT NULL";
            $canBeNull = $column->pk ? "NOT NULL" : "DEFAULT NULL";

            $columns[] = "  {$columnName} {$dataType} {$canBeNull}";
            if ($column->pk) {
                $primaryKeys[] = "{$columnName}";
            }
        }

        return [
            trim(implode(",\n", $columns)),
            trim(implode(",", $primaryKeys))
        ];
    }


    /**
     * @param BDSSchemaColumn $column
     * @return string
     */
    private function getDataType(BDSSchemaColumn $column): string
    {
        $columnSize = ($column->columnSize !== '')
            ? match ($column->dataType) {
                'bigint'              => '(20)',
                'bit'                 => '(1)',
                'decimal', 'float'    => "({$column->columnSize})",
                'int'                 => '(10)',
                'nvarchar'            => '(' . min(intval(1.25 * max(1, intval($column->columnSize))), 4000) . ')',
                'smallint'            => '(5)',
                'varchar'             => '(' . min(intval(1.25 * max(1, intval($column->columnSize))), 4000) . ' CHAR)',
                'uniqueidentifier'    => '(36)',
                default               => ''
            }
            : '';

        return match ($column->dataType) {
            'bigint', 'bit', 'int', 'smallint' => 'NUMBER',
            'datetime2'                        => 'TIMESTAMP WITH LOCAL TIME ZONE',
            'decimal'                          => 'DECIMAL',
            'float'                            => 'FLOAT',
            'nvarchar'                         => 'NVARCHAR2',
            default                            => 'VARCHAR2'
        } . $columnSize;
    }
}

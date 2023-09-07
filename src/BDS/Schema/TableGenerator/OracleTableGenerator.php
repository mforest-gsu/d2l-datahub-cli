<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\TableGenerator;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\BDS\Schema\TableGenerator;

class OracleTableGenerator extends TableGenerator
{
    protected static string $fileFormat = "oracle/%s.sql";


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
            . "QUIT;\n";
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
            $dataType = $this->getDataType($column);
            $canBeNull = $column->canBeNull ? "DEFAULT NULL" : "NOT NULL";
            $columnName = match (strtolower($column->name)) {
                "group", "comment", "order" => "D2L" . $column->name,
                default => $column->name
            };
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
        switch (strtoupper($column->dataType)) {
            case 'BIGINT':
                $dataType = 'NUMBER(20)';
                break;
            case 'BIT':
                $dataType = 'NUMBER(1)';
                break;
            case 'DATETIME2':
                $dataType = 'DATE';
                break;
            case 'DECIMAL':
                $dataType = 'NUMBER';
                if ($column->columnSize !== '') {
                    $dataType .= '(' . $column->columnSize . ')';
                }
                break;
            case 'FLOAT':
                $dataType = 'FLOAT';
                if ($column->columnSize !== '') {
                    $dataType .= '(' . $column->columnSize . ')';
                }
                break;
            case 'INT':
                $dataType = 'NUMBER(10)';
                break;
            case 'NVARCHAR':
                $dataType = 'NVARCHAR2' . '(' . min(max(1, intval($column->columnSize)), 4000) . ')';
                break;
            case 'SMALLINT':
                $dataType = 'NUMBER(5)';
                break;
            default:
                $dataType = 'VARCHAR2' . '(' . min(max(1, intval($column->columnSize)), 4000) . ')';
                break;
        }

        return $dataType;
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\TableGenerator;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\BDS\Schema\TableGenerator;

class MySQLTableGenerator extends TableGenerator
{
    protected static string $fileFormat = "mysql/%s.sql";


    /**
     * @param BDSSchema $dataset
     * @return string
     */
    protected function generateTable(
        BDSSchema $dataset,
        string $tableName
    ): string {
        $tableCols = $this->renderTableColumns($dataset);
        return ""
            . "DROP TABLE IF EXISTS `{$tableName}`;\n\n"
            . "CREATE TABLE `{$tableName}` (\n"
            . "  {$tableCols}\n"
            . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }


    /**
     * @param BDSSchema $dataset
     * @return string
     */
    private function renderTableColumns(BDSSchema $dataset): string
    {
        $columns = [];
        $primaryKeys = [];

        foreach ($dataset->columns as $column) {
            $dataType = $this->getDataType($column);
            $canBeNull = $column->pk && !$column->canBeNull ? "NOT NULL" : "DEFAULT NULL";
            $columns[] = "  `{$column->name}` {$dataType} {$canBeNull}";
            if ($column->pk) {
                $primaryKeys[] = $column->name;
            }
        }

        if (count($primaryKeys) > 0) {
            $columns[] = '  UNIQUE KEY (`' . trim(implode('`, `', $primaryKeys)) . '`)';
        }

        return trim(implode(",\n", $columns));
    }


    /**
     * @param BDSSchemaColumn $column
     * @return string
     */
    private function getDataType(BDSSchemaColumn $column): string
    {
        switch (strtoupper($column->dataType)) {
            case 'BIGINT':
            case 'FLOAT':
            case 'INT':
                $dataType = strtoupper($column->dataType);
                break;
            case 'BIT':
                $dataType = 'TINYINT';
                break;
            case 'DATETIME2':
                $dataType = 'DATETIME';
                break;
            case 'DECIMAL':
                $dataType = 'DECIMAL';
                if ($column->columnSize !== '') {
                    $dataType .= '(' . $column->columnSize . ')';
                }
                break;
            default:
                $dataType = 'VARCHAR';
                $columnSize = intval($column->columnSize);
                if ($columnSize < 1) {
                    $columnSize = 128;
                }
                if ($columnSize >= 10000) {
                    $dataType = 'TEXT';
                }
                $dataType .= '(' . $columnSize . ')';
                break;
        }

        return $dataType;
    }
}

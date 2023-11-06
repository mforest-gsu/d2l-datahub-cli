<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\TableGenerator;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;

class MySQLTableGenerator extends TableGenerator
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
        $columnSize = ($column->columnSize !== '')
            ? match ($column->dataType) {
                'nvarchar', 'varchar' => '(' . min(intval(max(1, intval($column->columnSize))), 9999) . ')',
                'decimal'             => "({$column->columnSize})",
                'uniqueidentifier'    => '(36)',
                default               => ''
            }
            : '';

        return match ($column->dataType) {
            'bigint', 'int', 'smallint', 'float' => strtoupper($column->dataType),
            'bit'                                => 'TINYINT',
            'datetime2'                          => 'DATETIME',
            'decimal'                            => 'DECIMAL',
            default                              => 'VARCHAR'
        } . $columnSize;
    }
}

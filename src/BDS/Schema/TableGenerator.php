<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaNameMap;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;

abstract class TableGenerator
{
    protected static string $fileFormat = "%s.sql";


    /**
     * @param BDSSchemaOptions $options
     * @param BDSSchemaNameMap $nameMap
     */
    public function __construct(
        protected BDSSchemaOptions $options,
        protected BDSSchemaNameMap $nameMap
    ) {
    }


    /**
     * @param BDSSchema $dataset
     * @return int
     */
    public function generate(BDSSchema $dataset): int
    {
        $tableName = $this->getTableName($dataset);
        return $this->saveTable(
            $tableName,
            $this->generateTable($dataset, $tableName)
        );
    }


    /**
     * @param BDSSchema $dataset
     * @return string
     */
    protected function getTableName(BDSSchema $dataset): string
    {
        return $this->nameMap->getTableName($dataset->name);
    }


    /**
     * @param BDSSchema $dataset
     * @return string
     */
    abstract protected function generateTable(BDSSchema $dataset, string $tableName): string;


    /**
     * @param string $tableName
     * @param string $contents
     * @param ?string $fileFormat
     * @return int
     */
    protected function saveTable(
        string $tableName,
        string $contents,
        ?string $fileFormat = null
    ): int {
        $bytesWritten = file_put_contents(
            "{$this->options->tablesDir}/" . sprintf($fileFormat ?? static::$fileFormat, $tableName),
            $contents
        );
        if ($bytesWritten === false) {
            throw new \RuntimeException();
        }
        return $bytesWritten;
    }
}

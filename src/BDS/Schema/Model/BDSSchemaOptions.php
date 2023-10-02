<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Model;

use D2L\DataHub\BDS\Schema\TableGenerator\OracleTableGenerator;
use mjfk23\Container\ArrayValue;
use mjfk23\Container\ObjectFactory;

class BDSSchemaOptions
{
    /**
     * @param mixed $values
     * @return self
     */
    public static function create(mixed $values): self
    {
        $appDir = ArrayValue::getStringNull($values, 'APP_DIR') ?? __DIR__ . '/../../../../';
        $confDir = ArrayValue::getStringNull($values, 'CONF_DIR') ?? "{$appDir}/conf";
        $workDir = ArrayValue::getStringNull($values, 'WORK_DIR') ?? "{$appDir}/work";
        $schemaDir = ArrayValue::getStringNull($values, 'SCHEMA_DIR') ?? "{$workDir}/schema";

        return ObjectFactory::createObject($values, self::class, fn (array $values): self => new self(
            schemaDir: $schemaDir,
            modulesDir: ArrayValue::getStringNull($values, 'SCHEMA_MODULES_DIR')
                ?? "{$schemaDir}/modules",
            datasetsDir: ArrayValue::getStringNull($values, 'SCHEMA_DATASETS_DIR')
                ?? "{$schemaDir}/datasets",
            tablesDir: ArrayValue::getStringNull($values, 'SCHEMA_TABLES_DIR')
                ?? "{$schemaDir}/tables/oracle",
            modulesFile: ArrayValue::getStringNull($values, 'SCHEMA_MODULES_FILE')
                ?? "{$confDir}/modules.json",
            apiMapFile: ArrayValue::getStringNull($values, 'SCHEMA_API_MAP')
                ?? "{$confDir}/api_map.json",
            tableMapFile: ArrayValue::getStringNull($values, 'SCHEMA_TABLE_MAP')
                ?? "{$confDir}/table_map_oracle.json",
            tableGenClass: ArrayValue::getStringNull($values, 'SCHEMA_TABLE_GEN_CLASS')
                ?? OracleTableGenerator::class,
        ));
    }


    /**
     * @param string $schemaDir
     * @param string $modulesDir
     * @param string $datasetsDir
     * @param string $tablesDir
     * @param string $modulesFile
     * @param string $apiMapFile
     * @param string $tableMapFile
     * @param string $tableGenClass
     */
    public function __construct(
        public string $schemaDir,
        public string $modulesDir,
        public string $datasetsDir,
        public string $tablesDir,
        public string $modulesFile,
        public string $apiMapFile,
        public string $tableMapFile,
        public string $tableGenClass,
    ) {
    }
}

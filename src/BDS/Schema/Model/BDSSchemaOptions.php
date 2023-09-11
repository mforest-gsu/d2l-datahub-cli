<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Model;

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
        $schemaDir = ArrayValue::getStringNull($values, 'BDS_SCHEMA_DIR') ?? "{$appDir}/work/schema";

        return ObjectFactory::createObject($values, self::class, fn (array $values): self => new self(
            schemaDir: $schemaDir,
            datasetsDir: ArrayValue::getStringNull($values, 'SCHEMA_DATASETS_DIR') ?? "{$schemaDir}/datasets",
            modulesDir: ArrayValue::getStringNull($values, 'SCHEMA_MODULES_DIR') ?? "{$schemaDir}/modules",
            tablesDir: ArrayValue::getStringNull($values, 'SCHEMA_TABLES_DIR') ?? "{$schemaDir}/tables",
            modulesFile: ArrayValue::getStringNull($values, 'BDS_SCHEMA_MODULES_FILE') ?? "{$confDir}/modules.json",
            apiMapFile: ArrayValue::getStringNull($values, 'BDS_SCHEMA_API_MAP') ?? "{$confDir}/api_map.json",
            tableMapFile: ArrayValue::getStringNull($values, 'BDS_SCHEMA_TABLE_MAP') ?? "{$confDir}/table_map.json",
            tableGenClass: ArrayValue::getStringNull($values, 'BDS_SCHEMA_TABLE_GEN_CLASS')
                ?? 'D2L\DataHub\BDS\Schema\TableGenerator\MySQLTableGenerator',
        ));
    }


    /**
     * @param string $schemaDir
     * @param string $datasetsDir
     * @param string $modulesDir
     * @param string $tablesDir
     * @param string $tableGenClass
     */
    public function __construct(
        public string $schemaDir,
        public string $datasetsDir,
        public string $modulesDir,
        public string $tablesDir,
        public string $modulesFile,
        public string $apiMapFile,
        public string $tableMapFile,
        public string $tableGenClass,
    ) {
    }
}

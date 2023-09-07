<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema;

use D2L\DataHub\BDS\Schema\Action\GenerateSQLTableSchemaAction;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\BDS\Schema\TableGenerator\MySQLTableGenerator;
use mjfk23\Container\DefinitionSource;
use mjfk23\Container\Env;
use Psr\Container\ContainerInterface;

class BDSSchemaDefinitions extends DefinitionSource
{
    /**
     * @inheritdoc
     */
    protected function createDefinitions(Env $env): array
    {
        $schemaDir = $env['SCHEMA_DIR'] ?? null;
        $datasetsDir = $env['SCHEMA_DATASETS_DIR'] ?? null;
        $modulesDir = $env['SCHEMA_MODULES_DIR'] ?? null;
        $tablesDir = $env['SCHEMA_TABLES_DIR'] ?? null;
        $schemaDir = is_string($schemaDir) ? $schemaDir : "{$env->appDir}/work/schema";
        $datasetsDir = is_string($datasetsDir) ? $datasetsDir : "{$schemaDir}/datasets";
        $modulesDir = is_string($modulesDir) ? $modulesDir : "{$schemaDir}/modules";
        $tablesDir = is_string($tablesDir) ? $tablesDir : "{$schemaDir}/tables";

        $confDir = $env['CONF_DIR'] ?? null;
        $modulesFile = $env['BDS_SCHEMA_MODULES_FILE'] ?? null;
        $apiMapFile = $env['BDS_SCHEMA_API_MAP'] ?? null;
        $tableMapFile = $env['BDS_SCHEMA_TABLE_MAP'] ?? null;
        $tableGenClass = $env['BDS_SCHEMA_TABLE_GEN_CLASS'] ?? null;
        $confDir = is_string($confDir) ? $confDir : "{$env->appDir}/conf";
        $modulesFile = is_string($modulesFile) ? $modulesFile : "{$confDir}/modules.json";
        $apiMapFile = is_string($apiMapFile) ? $apiMapFile : "{$confDir}/api_map.json";
        $tableMapFile = is_string($tableMapFile) ? $tableMapFile : "{$confDir}/table_map.json";
        $tableGenClass = is_string($tableGenClass) ? $tableGenClass : MySQLTableGenerator::class;

        return [
            BDSSchemaOptions::class => static::autowire(null, [
                'schemaDir' => $schemaDir,
                'datasetsDir' => $datasetsDir,
                'modulesDir' => $modulesDir,
                'tablesDir' => $tablesDir,
                'modulesFile' => $modulesFile,
                'apiMapFile' => $apiMapFile,
                'tableMapFile' => $tableMapFile,
                'tableGenClass' => $tableGenClass
            ]),
            GenerateSQLTableSchemaAction::class => static::autowire(null, [
                'tableGenFactory' => static::factory(function (ContainerInterface $c) {
                    return function (BDSSchemaOptions $options) use ($c): TableGenerator {
                        $tableGenerator = $c->get($options->tableGenClass);
                        if (!$tableGenerator instanceof TableGenerator) {
                            throw new \RuntimeException();
                        }
                        return $tableGenerator;
                    };
                })
            ])
        ];
    }
}

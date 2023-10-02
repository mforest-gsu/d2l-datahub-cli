<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Command;

use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\BDS\Schema\TableGenerator\TableGenerator;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class SchemaCommandOptions
{
    /**
     * @param Command $cmd
     * @param BDSSchemaOptions $options
     * @return void
     */
    public static function configModulesDir(
        Command $cmd,
        BDSSchemaOptions $options
    ): void {
        $cmd->addOption(
            name: 'modules-dir',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Available directory',
            default: $options->modulesDir
        );
    }


    /**
     * @param Command $cmd
     * @param BDSSchemaOptions $options
     * @return void
     */
    public static function configDatasetsDir(
        Command $cmd,
        BDSSchemaOptions $options
    ): void {
        $cmd->addOption(
            name: 'datasets-dir',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Datasets directory',
            default: $options->datasetsDir
        );
    }


    /**
     * @param Command $cmd
     * @param BDSSchemaOptions $options
     * @return void
     */
    public static function configTablesDir(
        Command $cmd,
        BDSSchemaOptions $options
    ): void {
        $cmd->addOption(
            name: 'tables-dir',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Tables directory',
            default: $options->tablesDir
        );
    }


    /**
     * @param Command $cmd
     * @param BDSSchemaOptions $options
     * @return void
     */
    public static function configModuleFile(
        Command $cmd,
        BDSSchemaOptions $options
    ): void {
        $cmd->addOption(
            name: 'modules-file',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Modules file',
            default: $options->modulesFile
        );
    }


    /**
     * @param Command $cmd
     * @param BDSSchemaOptions $options
     * @return void
     */
    public static function configAPIMapFile(
        Command $cmd,
        BDSSchemaOptions $options
    ): void {
        $cmd->addOption(
            name: 'api-map-file',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'API map file',
            default: $options->apiMapFile
        );
    }


    /**
     * @param Command $cmd
     * @param BDSSchemaOptions $options
     * @return void
     */
    public static function configTableMapFile(
        Command $cmd,
        BDSSchemaOptions $options
    ): void {
        $cmd->addOption(
            name: 'table-map-file',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Table map file',
            default: $options->tableMapFile
        );
    }


    /**
     * @param Command $cmd
     * @param BDSSchemaOptions $options
     * @return void
     */
    public static function configTableGenClass(
        Command $cmd,
        BDSSchemaOptions $options
    ): void {
        $cmd->addOption(
            name: 'table-gen-class',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Table generator class',
            default: $options->tableGenClass
        );
    }


    /**
     * @param InputInterface $input
     * @param BDSSchemaOptions $options
     * @return string
     */
    public static function getModulesDir(
        InputInterface $input,
        BDSSchemaOptions $options
    ): string {
        $modulesDir = $input->getOption('modules-dir') ?? $options->modulesDir;
        if (is_string($modulesDir) && is_dir($modulesDir)) {
            $options->modulesDir = $modulesDir;
            return $modulesDir;
        }
        throw new \RuntimeException("Modules directory not found");
    }


    /**
     * @param InputInterface $input
     * @param BDSSchemaOptions $options
     * @return string
     */
    public static function getDatasetsDir(
        InputInterface $input,
        BDSSchemaOptions $options
    ): string {
        $datasetsDir = $input->getOption('datasets-dir') ?? $options->datasetsDir;
        if (is_string($datasetsDir) && is_dir($datasetsDir)) {
            $options->datasetsDir = $datasetsDir;
            return $datasetsDir;
        }
        throw new \RuntimeException("Datasets directory not found");
    }


    /**
     * @param InputInterface $input
     * @param BDSSchemaOptions $options
     * @return string
     */
    public static function getTablesDir(
        InputInterface $input,
        BDSSchemaOptions $options
    ): string {
        $tablesDir = $input->getOption('tables-dir') ?? $options->tablesDir;
        if (is_string($tablesDir) && is_dir($tablesDir)) {
            $options->tablesDir = $tablesDir;
            return $tablesDir;
        }
        throw new \RuntimeException("Tables directory not found");
    }


    /**
     * @param InputInterface $input
     * @param BDSSchemaOptions $options
     * @return string
     */
    public static function getModulesFile(
        InputInterface $input,
        BDSSchemaOptions $options
    ): string {
        $modulesFile = $input->getOption('modules-file') ?? $options->modulesFile;
        if (is_string($modulesFile) && is_file($modulesFile)) {
            $options->modulesFile = $modulesFile;
            return $modulesFile;
        }
        throw new \RuntimeException("Modules file not found");
    }


    /**
     * @param InputInterface $input
     * @param BDSSchemaOptions $options
     * @return string
     */
    public static function getAPIMapFile(
        InputInterface $input,
        BDSSchemaOptions $options
    ): string {
        $apiMapFile = $input->getOption('api-map-file') ?? $options->apiMapFile;
        if (is_string($apiMapFile) && is_file($apiMapFile)) {
            $options->apiMapFile = $apiMapFile;
            return $apiMapFile;
        }
        throw new \RuntimeException("API map file not found");
    }


    /**
     * @param InputInterface $input
     * @param BDSSchemaOptions $options
     * @return string
     */
    public static function getTableMapFile(
        InputInterface $input,
        BDSSchemaOptions $options
    ): string {
        $tableMapFile = $input->getOption('table-map-file') ?? $options->tableMapFile;
        if (is_string($tableMapFile) && is_file($tableMapFile)) {
            $options->tableMapFile = $tableMapFile;
            return $tableMapFile;
        }
        throw new \RuntimeException("Table map file not found");
    }


    /**
     * @param InputInterface $input
     * @param BDSSchemaOptions $options
     * @return string
     */
    public static function getTableGenClass(
        InputInterface $input,
        BDSSchemaOptions $options
    ): string {
        $tableGenClass = $input->getOption('table-gen-class') ?? $options->tableGenClass;
        if (is_string($tableGenClass)) {
            if (!class_exists($tableGenClass)) {
                throw new \ReflectionException("Class not found: {$tableGenClass}");
            }
            $classDef = new \ReflectionClass($tableGenClass);
            if (!$classDef->isInstantiable() || !$classDef->isSubclassOf(TableGenerator::class)) {
                throw new \ReflectionException("Invalid class type: {$tableGenClass}");
            }
            /** @var \ReflectionClass<TableGenerator> $classDef */
            $options->tableGenClass = $classDef->getName();
            return $options->tableGenClass;
        }
        throw new \RuntimeException("Table generator class not found");
    }
}

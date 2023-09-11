<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Command;

use D2L\DataHub\BDS\Schema\Action\DownloadModulesAction;
use D2L\DataHub\BDS\Schema\Action\GenerateDatasetSchemaAction;
use D2L\DataHub\BDS\Schema\Action\GenerateSQLTableSchemaAction;
use D2L\DataHub\BDS\Schema\Action\SaveDatasetSchemaAction;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaModules;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\BDS\Schema\TableGenerator;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'bds:schema:generate')]
class GenerateSchemaCommand extends Command
{
    /**
     * @param BDSSchemaOptions $options
     * @param BDSSchemaModules $modules
     * @param DownloadModulesAction $downloadModules
     * @param GenerateDatasetSchemaAction $generateDatasetSchema
     * @param SaveDatasetSchemaAction $saveDatasetSchema
     * @param GenerateSQLTableSchemaAction $generateSQLTableSchema
     */
    public function __construct(
        private BDSSchemaOptions $options,
        private BDSSchemaModules $modules,
        private DownloadModulesAction $downloadModules,
        private GenerateDatasetSchemaAction $generateDatasetSchema,
        private SaveDatasetSchemaAction $saveDatasetSchema,
        private GenerateSQLTableSchemaAction $generateSQLTableSchema
    ) {
        parent::__construct();
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addOption(
                name: 'schema-dir',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Schema directory',
                default: $this->options->schemaDir
            )
            ->addOption(
                name: 'datasets-dir',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Datasets directory',
                default: $this->options->datasetsDir
            )
            ->addOption(
                name: 'modules-dir',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Modules directory',
                default: $this->options->modulesDir
            )
            ->addOption(
                name: 'tables-dir',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Tables directory',
                default: $this->options->tablesDir
            )
            ->addOption(
                name: 'modules-file',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Modules file',
                default: $this->options->modulesFile
            )
            ->addOption(
                name: 'api-map-file',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'API map file',
                default: $this->options->apiMapFile
            )
            ->addOption(
                name: 'table-map-file',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Table map file',
                default: $this->options->tableMapFile
            )
            ->addOption(
                name: 'table-gen-class',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Table generator class',
                default: $this->options->tableGenClass
            )
            ->addOption(
                name: 'skip-download',
                description: 'Skip module download'
            )
            ->addOption(
                name: 'skip-sql-tables',
                description: 'Skip SQL table schema generation'
            )
            ->addArgument(
                name: 'module',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Module to download'
            );
    }


    /**
     * @param InputInterface $input
     * @return array{0:bool, 1:bool, 2:string[]}
     */
    protected function collectInputs(InputInterface $input): array
    {
        $schemaDir = $input->getOption('schema-dir') ?? $this->options->schemaDir;
        if (is_string($schemaDir) && is_dir($schemaDir)) {
            $this->options->schemaDir = $schemaDir;
        } else {
            throw new \RuntimeException("Schema directory not found");
        }

        $datasetsDir = $input->getOption('datasets-dir') ?? $this->options->datasetsDir;
        if (is_string($datasetsDir) && is_dir($datasetsDir)) {
            $this->options->datasetsDir = $datasetsDir;
        } else {
            throw new \RuntimeException("Datasets directory not found");
        }

        $modulesDir = $input->getOption('modules-dir') ?? $this->options->modulesDir;
        if (is_string($modulesDir) && is_dir($modulesDir)) {
            $this->options->modulesDir = $modulesDir;
        } else {
            throw new \RuntimeException("Modules directory not found");
        }

        $tablesDir = $input->getOption('tables-dir') ?? $this->options->tablesDir;
        if (is_string($tablesDir) && is_dir($tablesDir)) {
            $this->options->tablesDir = $tablesDir;
        } else {
            throw new \RuntimeException("Tables directory not found");
        }

        $modulesFile = $input->getOption('modules-file') ?? $this->options->modulesFile;
        if (is_string($modulesFile) && is_file($modulesFile)) {
            $this->options->modulesFile = $modulesFile;
        } else {
            throw new \RuntimeException("Modules file not found");
        }

        $apiMapFile = $input->getOption('api-map-file') ?? $this->options->apiMapFile;
        if (is_string($apiMapFile) && is_file($apiMapFile)) {
            $this->options->apiMapFile = $apiMapFile;
        } else {
            throw new \RuntimeException("API map file not found");
        }

        $tableMapFile = $input->getOption('table-map-file') ?? $this->options->tableMapFile;
        if (is_string($tableMapFile) && is_file($tableMapFile)) {
            $this->options->tableMapFile = $tableMapFile;
        } else {
            throw new \RuntimeException("Table map file not found");
        }

        $tableGenClass = $input->getOption('table-gen-class') ?? $this->options->tableGenClass;
        if (is_string($tableGenClass)) {
            if (!class_exists($tableGenClass)) {
                throw new \ReflectionException("Class not found: {$tableGenClass}");
            }
            $classDef = new \ReflectionClass($tableGenClass);
            if (!$classDef->isInstantiable() || !$classDef->isSubclassOf(TableGenerator::class)) {
                throw new \ReflectionException("Invalid class type: {$tableGenClass}");
            }
            /** @var \ReflectionClass<TableGenerator> $classDef */
            $this->options->tableGenClass = $classDef->getName();
        } else {
            throw new \RuntimeException("Table generator class not found");
        }

        $modules = $this->getArgumentArray(
            $input,
            'module',
            $this->modules->getModules()
        );
        if (count($modules) < 1) {
            $modules = $this->modules->getModules();
        }

        return [
            $input->getOption('skip-download') === false,
            $input->getOption('skip-sql-tables') === false,
            $modules
        ];
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        list(
            $downloadModules,
            $genSQLTables,
            $modules
        ) = $this->collectInputs($input);

        if ($downloadModules) {
            $this->downloadModules->execute($modules);
        }

        $datasetSchema = $this->generateDatasetSchema->execute($modules);

        $this->saveDatasetSchema->execute($datasetSchema);

        if ($genSQLTables) {
            $this->generateSQLTableSchema->execute($datasetSchema);
        }

        return static::SUCCESS;
    }
}

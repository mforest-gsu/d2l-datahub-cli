<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Command;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaModules;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\BDS\Schema\ModuleParser;
use D2L\DataHub\Utils\FileIO;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'schema:generate')]
class GenerateSchemaCommand extends Command
{
    /**
     * @param BDSSchemaOptions $options
     * @param BDSSchemaModules $modules
     * @param ModuleParser $moduleParser
     */
    public function __construct(
        private BDSSchemaOptions $options,
        private BDSSchemaModules $modules,
        private ModuleParser $moduleParser
    ) {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        SchemaCommandOptions::configModulesDir($this, $this->options);
        SchemaCommandOptions::configModuleFile($this, $this->options);
        SchemaCommandOptions::configDatasetsDir($this, $this->options);
        $this
            ->addOption(
                name: 'api-map-file',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'API map file',
                default: $this->options->apiMapFile
            )
            ->addArgument(
                name: 'module',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Module to download'
            );
    }


    /**
     * @param InputInterface $input
     * @return array{0:string[]}
     */
    protected function collectInputs(InputInterface $input): array
    {
        SchemaCommandOptions::getModulesDir($input, $this->options);
        SchemaCommandOptions::getModulesFile($input, $this->options);
        SchemaCommandOptions::getDatasetsDir($input, $this->options);

        $apiMapFile = $input->getOption('api-map-file') ?? $this->options->apiMapFile;
        if (is_string($apiMapFile) && is_file($apiMapFile)) {
            $this->options->apiMapFile = $apiMapFile;
        } else {
            throw new \RuntimeException("API map file not found");
        }

        $modules = $this->getArgumentArray(
            $input,
            'module',
            $this->modules->getModules()
        );
        if (count($modules) < 1) {
            $modules = $this->modules->getModules();
        }

        return [$modules];
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
        list($modules) = $this->collectInputs($input);

        $datasets = [];
        foreach ($modules as $moduleName) {
            $datasets += $this->generateDatasetSchema($moduleName);
        }
        ksort($datasets);

        foreach ($datasets as $dataset) {
            $this->saveDataset(
                str_replace(' ', '', $dataset->name),
                $dataset
            );
        }
        $this->saveDataset('all', $datasets);

        return static::SUCCESS;
    }


    /**
     * @param string $moduleName
     * @return array<string,BDSSchema>
     */
    private function generateDatasetSchema(string $moduleName): array
    {
        $start = microtime(true);

        $datasets = $this->moduleParser->parse($moduleName);

        $this->logger?->info("<Generate Schema> " . $this->formatLogResults([
            "Module" => $moduleName,
            "Datasets" => count($datasets),
            "Elapsed" => $this->getElapsedTime($start)
        ]));

        return $datasets;
    }


    /**
     * @param string $name
     * @param BDSSchema|array<BDSSchema> $dataset
     * @return int
     */
    private function saveDataset(
        string $name,
        BDSSchema|array $dataset
    ): int {
        if ($dataset instanceof BDSSchema) {
            $dataset = ["{$dataset->name}" => $dataset];
        }

        $bytes = FileIO::putContents(
            "{$this->options->datasetsDir}/{$name}.json",
            FileIO::jsonEncode($dataset)
        );

        return $bytes;
    }
}

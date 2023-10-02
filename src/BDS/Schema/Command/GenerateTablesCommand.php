<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Command;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\BDS\Schema\TableGenerator\TableGenerator;
use D2L\DataHub\Utils\FileIO;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'schema:generate-tables')]
class GenerateTablesCommand extends Command
{
    /**
     * @param BDSSchemaOptions $options
     * @param (callable(BDSSchemaOptions $options): TableGenerator) $tableGenFactory
     */
    public function __construct(
        private BDSSchemaOptions $options,
        private mixed $tableGenFactory
    ) {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        SchemaCommandOptions::configDatasetsDir($this, $this->options);
        SchemaCommandOptions::configTablesDir($this, $this->options);
        SchemaCommandOptions::configTableMapFile($this, $this->options);
        SchemaCommandOptions::configTableGenClass($this, $this->options);

        $this->addArgument(
            name: 'dataset',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Dataset to generate DDL for'
        );
    }


    /**
     * @param InputInterface $input
     * @return array{0:array<string,BDSSchema>}
     */
    protected function collectInputs(InputInterface $input): array
    {
        SchemaCommandOptions::getDatasetsDir($input, $this->options);
        SchemaCommandOptions::getTablesDir($input, $this->options);
        SchemaCommandOptions::getTableMapFile($input, $this->options);
        SchemaCommandOptions::getTableGenClass($input, $this->options);

        $datasets = array_map(
            fn ($v) => BDSSchema::create($v),
            FileIO::jsonDecode(
                FileIO::getContents("{$this->options->datasetsDir}/all.json")
            )
        );

        $selected = $this->getArgumentArray($input, 'dataset');
        if (count($selected) > 0) {
            $datasets = array_filter(
                $datasets,
                fn ($v) => in_array(
                    str_replace(' ', '', $v->name),
                    $selected,
                    true
                )
            );
        }

        return [$datasets];
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
        list($datasets) = $this->collectInputs($input);

        $tableGenerator = ($this->tableGenFactory)($this->options);

        $bytes = 0;
        foreach ($datasets as $dataset) {
            $bytes += $this->generateTable($tableGenerator, $dataset);
        }

        return static::SUCCESS;
    }


    /**
     * @param TableGenerator $tableGenerator
     * @param BDSSchema $dataset
     * @return int
     */
    private function generateTable(
        TableGenerator $tableGenerator,
        BDSSchema $dataset
    ): int {
        $start = microtime(true);

        $bytes = $tableGenerator->generate($dataset);

        $this->logger?->info("<Generate Table> " . $this->formatLogResults([
            "Dataset" => $dataset->name,
            "Class" => (new \ReflectionClass($tableGenerator))->getShortName(),
            "Size" => $bytes,
            "Elapsed" => $this->getElapsedTime($start)
        ]));

        return $bytes;
    }
}

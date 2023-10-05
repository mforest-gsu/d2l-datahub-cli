<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\ExtractProcessor\ExtractProcessor;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Schema\Command\SchemaCommandOptions;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'extracts:process')]
class ProcessExtractCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     * @param (callable(BDSExtractOptions $options):ExtractProcessor) $processorFactory
     */
    public function __construct(
        private BDSExtractOptions $options,
        private BDSSchemaOptions $schemaOptions,
        private mixed $processorFactory,
    ) {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        SchemaCommandOptions::configDatasetsDir($this, $this->schemaOptions);
        ExtractCommandOptions::configDownloadsDir($this, $this->options);
        ExtractCommandOptions::configProcessDir($this, $this->options);
        ExtractCommandOptions::configProcessorClass($this, $this->options);
        ExtractCommandOptions::configExtract($this);
    }


    /**
     * @param InputInterface $input
     * @return array{0:ExtractProcessor,1:BDSSchema,2:string,3:string}
     */
    protected function collectInputs(InputInterface $input): array
    {
        SchemaCommandOptions::getDatasetsDir($input, $this->schemaOptions);
        ExtractCommandOptions::getDownloadsDir($input, $this->options);
        ExtractCommandOptions::getProcessDir($input, $this->options);
        ExtractCommandOptions::getProcessorClass($input, $this->options);
        list($extractName, $datasetName, $bdsType) = ExtractCommandOptions::getExtract($input);

        return [
            ($this->processorFactory)($this->options),
            ExtractCommandOptions::getSchema(
                sprintf(
                    "%s/%s.json",
                    $this->schemaOptions->datasetsDir,
                    $datasetName
                )
            ),
            $bdsType,
            $extractName,
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
            $extractProcessor,
            $schema,
            $bdsType,
            $extractName
        ) = $this->collectInputs($input);

        $rows = $extractProcessor->processExtract(
            $schema,
            $bdsType,
            $extractName
        );

        $this->logger?->info("<Process Extract> " . $this->formatLogResults([
            "Extract" => $extractName,
            "Class" => (new \ReflectionClass($extractProcessor))->getShortName(),
            "Rows" => $rows
        ]));

        return static::SUCCESS;
    }
}

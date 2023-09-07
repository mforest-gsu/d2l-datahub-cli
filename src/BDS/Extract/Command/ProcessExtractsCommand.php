<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Action\GetDatasetsToProcessAction;
use D2L\DataHub\BDS\Extract\Action\GetDownloadedExtractsAction;
use D2L\DataHub\BDS\Extract\Action\GetProcessedExtractsAction;
use D2L\DataHub\BDS\Extract\Action\ProcessExtractsAction;
use D2L\DataHub\BDS\Extract\ExtractProcessor;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'bds:extracts:process')]
class ProcessExtractsCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     * @param (callable(BDSExtractOptions $options):ExtractProcessor) $extractProcessorFactory
     * @param GetDownloadedExtractsAction $getDownloadedExtracts
     * @param GetProcessedExtractsAction $getProcessedExtracts
     * @param GetDatasetsToProcessAction $getDatasetsToProcess
     * @param ProcessExtractsAction $processExtracts
     */
    public function __construct(
        private BDSExtractOptions $options,
        private mixed $extractProcessorFactory,
        private GetDownloadedExtractsAction $getDownloadedExtracts,
        private GetProcessedExtractsAction $getProcessedExtracts,
        private GetDatasetsToProcessAction $getDatasetsToProcess,
        private ProcessExtractsAction $processExtracts
    ) {
        parent::__construct(
            logStartFinish: false,
            logError: false,
        );
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addOption(
                name: 'downloads-dir',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Extracts directory',
                default: $this->options->downloadsDir
            )
            ->addOption(
                name: 'process-dir',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Process directory',
                default: $this->options->processDir
            )
            ->addOption(
                name: 'extract-processor-class',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Extract processor class',
                default: $this->options->extractProcessorClass
            )
            ->addOption(
                name: 'skip-full',
                description: 'Skip processing full datasets'
            )
            ->addOption(
                name: 'skip-diff',
                description: 'Skip processing diff datasets'
            )
            ->addOption(
                name: 'force',
                description: 'Force processing of datasets'
            )
            ->addArgument(
                name: 'dataset',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Datasets to process'
            );
    }


    /**
     * @param InputInterface $input
     * @return array{0:bool,1:bool,2:bool,3:string[]}
     */
    protected function collectInputs(InputInterface $input): array
    {
        $downloadsDir = $input->getOption('downloads-dir') ?? $this->options->downloadsDir;
        if (is_string($downloadsDir) && is_dir($downloadsDir)) {
            $this->options->downloadsDir = $downloadsDir;
        } else {
            throw new \RuntimeException("Downloads directory not found");
        }

        $processDir = $input->getOption('process-dir') ?? $this->options->processDir;
        if (is_string($processDir) && is_dir($processDir)) {
            $this->options->processDir = $processDir;
        } else {
            throw new \RuntimeException("Process directory not found");
        }

        $extractProcessorClass = $input->getOption('extract-processor-class') ?? $this->options->extractProcessorClass;
        if (is_string($extractProcessorClass)) {
            if (!class_exists($extractProcessorClass)) {
                throw new \ReflectionException("Class not found: {$extractProcessorClass}");
            }
            $classDef = new \ReflectionClass($extractProcessorClass);
            if (!$classDef->isInstantiable() || !$classDef->isSubclassOf(ExtractProcessor::class)) {
                throw new \ReflectionException("Invalid class type: {$extractProcessorClass}");
            }
            /** @var \ReflectionClass<ExtractProcessor> $classDef */
            $this->options->extractProcessorClass = $classDef->getName();
        } else {
            throw new \RuntimeException("Table generator class not set");
        }

        return [
            $input->getOption('skip-full') === false,
            $input->getOption('skip-diff') === false,
            $input->getOption('force') !== false,
            $this->getArgumentArray($input, 'dataset')
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
            $includeFull,
            $includeDiff,
            $forceProcess,
            $selectedDatasets
        ) = $this->collectInputs($input);

        /** @var ExtractProcessor $extractProcessor */
        $extractProcessor = ($this->extractProcessorFactory)($this->options);

        $downloadedExtracts = $this->getDownloadedExtracts->execute();
        $processedExtracts = !$forceProcess
            ? $this->getProcessedExtracts->execute($extractProcessor::$processFileExtension)
            : [];
        $datasetsToProcess = $this->getDatasetsToProcess->execute(
            $includeFull,
            $includeDiff,
            $selectedDatasets,
            $downloadedExtracts,
            $processedExtracts
        );

        $this->processExtracts->execute(
            $datasetsToProcess,
            $extractProcessor
        );

        $this->logger?->info(str_pad("", 51, "="));

        return static::SUCCESS;
    }
}

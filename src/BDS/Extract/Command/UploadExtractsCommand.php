<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Action\GetDatasetsToUploadAction;
use D2L\DataHub\BDS\Extract\Action\GetProcessedExtractsAction;
use D2L\DataHub\BDS\Extract\Action\GetUploadedExtractsAction;
use D2L\DataHub\BDS\Extract\Action\UploadExtractsAction;
use D2L\DataHub\BDS\Extract\ExtractUploader;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'bds:extracts:upload')]
class UploadExtractsCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     * @param (callable(BDSExtractOptions $options):ExtractUploader) $extractUploaderFactory
     * @param GetProcessedExtractsAction $getProcessedExtracts
     * @param GetUploadedExtractsAction $getUploadedExtracts
     * @param GetDatasetsToUploadAction $getDatasetsToUpload
     * @param UploadExtractsAction $uploadExtracts
     */
    public function __construct(
        private BDSExtractOptions $options,
        private mixed $extractUploaderFactory,
        private GetProcessedExtractsAction $getProcessedExtracts,
        private GetUploadedExtractsAction $getUploadedExtracts,
        private GetDatasetsToUploadAction $getDatasetsToUpload,
        private UploadExtractsAction $uploadExtracts
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
                name: 'process-dir',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Process directory',
                default: $this->options->processDir
            )
            ->addOption(
                name: 'uploads-dir',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Extracts directory',
                default: $this->options->uploadsDir
            )
            ->addOption(
                name: 'extract-uploader-class',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Extract uploader class',
                default: $this->options->extractUploaderClass
            )
            ->addOption(
                name: 'skip-full',
                description: 'Skip uploading full datasets'
            )
            ->addOption(
                name: 'skip-diff',
                description: 'Skip uploading diff datasets'
            )
            ->addOption(
                name: 'force',
                description: 'Force uploading of datasets'
            )
            ->addArgument(
                name: 'dataset',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Datasets to upload'
            );
    }


    /**
     * @param InputInterface $input
     * @return array{0:bool,1:bool,2:bool,3:string[]}
     */
    protected function collectInputs(InputInterface $input): array
    {
        $processDir = $input->getOption('process-dir') ?? $this->options->processDir;
        if (is_string($processDir) && is_dir($processDir)) {
            $this->options->processDir = $processDir;
        } else {
            throw new \RuntimeException("Process directory not found");
        }

        $uploadsDir = $input->getOption('uploads-dir') ?? $this->options->downloadsDir;
        if (is_string($uploadsDir) && is_dir($uploadsDir)) {
            $this->options->uploadsDir = $uploadsDir;
        } else {
            throw new \RuntimeException("Uploads directory not found");
        }

        $extractUploaderClass = $input->getOption('extract-uploader-class') ?? $this->options->extractUploaderClass;
        if (is_string($extractUploaderClass)) {
            if (!class_exists($extractUploaderClass)) {
                throw new \ReflectionException("Class not found: {$extractUploaderClass}");
            }
            $classDef = new \ReflectionClass($extractUploaderClass);
            if (!$classDef->isInstantiable() || !$classDef->isSubclassOf(ExtractUploader::class)) {
                throw new \ReflectionException("Invalid class type: {$extractUploaderClass}");
            }
            /** @var \ReflectionClass<ExtractUploader> $classDef */
            $this->options->extractUploaderClass = $classDef->getName();
        } else {
            throw new \RuntimeException("Extract uploader class not set");
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
            $forceUpload,
            $selectedDatasets
        ) = $this->collectInputs($input);

        /** @var ExtractUploader $extractUploader */
        $extractUploader = ($this->extractUploaderFactory)($this->options);

        $processedExtracts = $this->getProcessedExtracts->execute($extractUploader::$processFileExtension);
        $uploadedExtracts = !$forceUpload
            ? $this->getUploadedExtracts->execute($extractUploader::$uploadFileExtension)
            : [];
        $datasetsToUpload = $this->getDatasetsToUpload->execute(
            $includeFull,
            $includeDiff,
            $selectedDatasets,
            $processedExtracts,
            $uploadedExtracts
        );

        $this->uploadExtracts->execute(
            $datasetsToUpload,
            $extractUploader
        );

        $this->logger?->info(str_pad("", 51, "="));

        return static::SUCCESS;
    }
}

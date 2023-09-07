<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Action\DownloadExtractsAction;
use D2L\DataHub\BDS\Extract\Action\GetAvailableDatasetsAction;
use D2L\DataHub\BDS\Extract\Action\GetAvailableExtractsAction;
use D2L\DataHub\BDS\Extract\Action\GetDownloadedExtractsAction;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'bds:extracts:download')]
class DownloadExtractsCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     * @param GetDownloadedExtractsAction $getDownloadedExtracts
     * @param GetAvailableDatasetsAction $getAvailableDatasets
     * @param GetAvailableExtractsAction $getAvailableExtracts
     */
    public function __construct(
        private BDSExtractOptions $options,
        private GetDownloadedExtractsAction $getDownloadedExtracts,
        private GetAvailableDatasetsAction $getAvailableDatasets,
        private GetAvailableExtractsAction $getAvailableExtracts,
        private DownloadExtractsAction $downloadExtracts
    ) {
        parent::__construct(
            logStartFinish: true,
            logError: true,
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
                name: 'skip-full',
                description: 'Skip downloading full datasets'
            )
            ->addOption(
                name: 'skip-diff',
                description: 'Skip downloading diff datasets'
            )
            ->addOption(
                name: 'force',
                description: 'Force downloading of datasets'
            )
            ->addArgument(
                name: 'dataset',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Datasets to download'
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
            $forceDownload,
            $selectedDatasets
        ) = $this->collectInputs($input);

        $availableDatasets = $this->getAvailableDatasets->execute($selectedDatasets);
        $downloadedExtracts = !$forceDownload
            ? $this->getDownloadedExtracts->execute()
            : [];
        $extractsToDownload = $this->getAvailableExtracts->execute(
            $downloadedExtracts,
            $availableDatasets,
            $includeFull,
            $includeDiff
        );

        $this->downloadExtracts->execute($extractsToDownload);

        $this->logger?->info(str_pad("", 51, "="));

        return static::SUCCESS;
    }
}

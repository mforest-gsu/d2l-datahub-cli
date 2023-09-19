<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Action\GetAvailableDatasetsAction;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'bds:extracts:get-available')]
class GetAvailableExtractsCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     * @param GetAvailableDatasetsAction $getAvailableDatasets
     */
    public function __construct(
        private BDSExtractOptions $options,
        private GetAvailableDatasetsAction $getAvailableDatasets
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
                name: 'downloads-dir',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Extracts directory',
                default: $this->options->downloadsDir
            );
    }


    /**
     * @param InputInterface $input
     * @return void
     */
    protected function collectInputs(InputInterface $input): void
    {
        $downloadsDir = $input->getOption('downloads-dir') ?? $this->options->downloadsDir;
        if (is_string($downloadsDir) && is_dir($downloadsDir)) {
            $this->options->downloadsDir = $downloadsDir;
        } else {
            throw new \RuntimeException("Downloads directory not found");
        }
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
        $this->collectInputs($input);

        $selectedDatasets = [];
        $this->getAvailableDatasets->execute($selectedDatasets);

        return static::SUCCESS;
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\Utils\FileList;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ListExtractsCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     */
    public function __construct(protected BDSExtractOptions $options)
    {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->configureSource();
        $this->configureDestination();

        $this
            ->addOption(
                name: 'skip-fulldiff',
                description: 'Skip full diff extracts'
            )
            ->addOption(
                name: 'skip-full',
                description: 'Skip full extracts'
            )
            ->addOption(
                name: 'skip-diff',
                description: 'Skip diff extracts'
            )
            ->addOption(
                name: 'all',
                description: 'Show all extracts from source'
            )
            ->addArgument(
                name: 'datasets',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Dataset(s) to perform action on'
            );
    }


    /**
     * @return static
     */
    abstract protected function configureSource(): static;


    /**
     * @return static
     */
    abstract protected function configureDestination(): static;


    /**
     * @param InputInterface $input
     * @return array{0:array{0:string,1:string},1:array{0:string,1:string},2:bool,3:bool,4:bool,5:bool,6:string[]}
     */
    protected function collectInputs(InputInterface $input): array
    {
        return [
            $this->getSource($input),
            $this->getDestination($input),
            $input->getOption('skip-fulldiff') !== false,
            $input->getOption('skip-full') !== false,
            $input->getOption('skip-diff') !== false,
            $input->getOption('all') !== false,
            $this->getArgumentArray($input, 'datasets')
        ];
    }


    /**
     * @param InputInterface $input
     * @return array{0:string,1:string}
     */
    abstract protected function getSource(InputInterface $input): array;


    /**
     * @param InputInterface $input
     * @return array{0:string,1:string}
     */
    abstract protected function getDestination(InputInterface $input): array;


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
            list($srcDir, $srcFileExt),
            list($dstDir, $dstFileExt),
            $skipFullDiff,
            $skipFull,
            $skipDiff,
            $all,
            $selected
        ) = $this->collectInputs($input);

        $srcFiles = array_keys(FileList::get($srcDir, $srcFileExt));
        $dstFiles = array_keys(FileList::get($dstDir, $dstFileExt));
        $files = $all ? $srcFiles : array_diff($srcFiles, $dstFiles);

        foreach ($files as $extractName) {
            list($datasetName,,, $bdsType) = explode('_', $extractName);
            if (
                (count($selected) < 1 || in_array($datasetName, $selected, true))
                && !($skipFullDiff && $bdsType === 'FullDiff')
                && !($skipFull && $bdsType === 'Full')
                && !($skipDiff && $bdsType === 'Diff')
            ) {
                $output->writeln($extractName);
            }
        }

        return static::SUCCESS;
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\Utils\FileIO;
use mjfk23\Console\Command\Command;
use mjfk23\D2LAPI\DataHub\DataHubAPI;
use mjfk23\D2LAPI\DataHub\Model\BDSExtractInfo;
use mjfk23\D2LAPI\DataHub\Model\BDSInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'extracts:fetch')]
class FetchExtractsCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     * @param DataHubAPI $dataHubAPI
     */
    public function __construct(
        private BDSExtractOptions $options,
        private DataHubAPI $dataHubAPI
    ) {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        ExtractCommandOptions::configAvailableDir($this, $this->options);

        $this->addArgument(
            name: 'datasets',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Dataset(s) to perform action on'
        );
    }


    /**
     * @param InputInterface $input
     * @return array{0:string[]}
     */
    protected function collectInputs(InputInterface $input): array
    {
        ExtractCommandOptions::getAvailableDir($input, $this->options);

        return [$this->getArgumentArray($input, 'datasets')];
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
        list($selected) = $this->collectInputs($input);

        $datasets = $this->getAvailableDatasets($selected);

        $totalDatasets = $totalExtracts = $totalBytes = 0;

        foreach ($datasets as $name => $dataset) {
            foreach (($dataset->Full?->Extracts ?? []) as $extract) {
                $this->saveExtractInfo($name, $extract);
                $totalBytes += $extract->DownloadSize;
                $totalExtracts++;
            }

            foreach (($dataset->Differential?->Extracts ?? []) as $extract) {
                $this->saveExtractInfo($name, $extract);
                $totalBytes += $extract->DownloadSize;
                $totalExtracts++;
            }

            $totalDatasets++;
        }

        $this->logger?->info("<Available Extracts> " . $this->formatLogResults([
            "Datasets" => $totalDatasets,
            "Extracts" => $totalExtracts,
            "Bytes" => $totalBytes
        ]));

        return static::SUCCESS;
    }


    /**
     * @param string[] $selected
     * @return array<string,BDSInfo> $datasets
     */
    private function getAvailableDatasets(array $selected): array
    {
        return array_column(
            array_filter(
                array_map(
                    fn ($v) => [$v, str_replace(' ', '', $v->Name)],
                    $this->dataHubAPI->getBDS()
                ),
                fn ($v) => count($selected) < 1 || in_array($v[1], $selected, true)
            ),
            0,
            1
        );
    }


    /**
     * @param string $datasetName
     * @param BDSExtractInfo $extract
     * @return int
     */
    private function saveExtractInfo(
        string $datasetName,
        BDSExtractInfo $extract
    ): int {
        $extractName = $this->getExtractName($datasetName, $extract);
        return FileIO::putContents(
            "{$this->options->availableDir}/{$extractName}.json",
            FileIO::jsonEncode($extract)
        );
    }


    /**
     * @param string $datasetName
     * @param BDSExtractInfo $extract
     * @return string
     */
    private function getExtractName(
        string $datasetName,
        BDSExtractInfo $extract
    ): string {
        return implode(
            '_',
            [
                $datasetName,
                $extract->QueuedForProcessingDate->format('Ymd_His'),
                substr($extract->BdsType, 0, 4)
            ]
        );
    }
}

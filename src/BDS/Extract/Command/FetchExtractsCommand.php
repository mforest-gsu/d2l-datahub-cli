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
        ExtractCommandOptions::configDatasetList($this);
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

        list($totalDatasets, $totalExtracts, $totalBytes) = $this->saveAvailableDatasets(
            $this->getAvailableDatasets($selected)
        );

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
     * @param array<string,BDSInfo> $datasets
     * @return array{0:int,1:int,2:int}
     */
    private function saveAvailableDatasets(array $datasets): array
    {
        $totalDatasets = $totalExtracts = $totalBytes = 0;
        foreach ($datasets as $name => $dataset) {
            list($fullExtracts, $fullBytes) = $this->saveExtracts($name, $dataset->Full?->Extracts ?? []);
            list($diffExtracts, $diffBytes) = $this->saveExtracts($name, $dataset->Differential?->Extracts ?? []);

            $totalDatasets++;
            $totalExtracts += $fullExtracts + $diffExtracts;
            $totalBytes += $fullBytes + $diffBytes;
        }
        return [$totalDatasets, $totalExtracts, $totalBytes];
    }


    /**
     * @param string $datasetName
     * @param BDSExtractInfo[] $extracts
     * @return array{0:int,1:int}
     */
    private function saveExtracts(
        string $datasetName,
        array $extracts
    ): array {
        $totalExtracts = $totalBytes = 0;
        foreach ($extracts as $extract) {
            $extractName = implode(
                '_',
                [
                    $datasetName,
                    $extract->QueuedForProcessingDate->format('Ymd_His'),
                    substr($extract->BdsType, 0, 4)
                ]
            );
            $totalBytes += FileIO::putContents(
                "{$this->options->availableDir}/{$extractName}.json",
                FileIO::jsonEncode($extract)
            );
            $totalExtracts++;
        }
        return [$totalExtracts, $totalBytes];
    }
}

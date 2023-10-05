<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\Utils\FileIO;
use D2L\DataHub\Utils\FileList;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'extracts:list:fulldiff')]
class ListFullDiffExtractsCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     */
    public function __construct(private BDSExtractOptions $options)
    {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        ExtractCommandOptions::configDownloadsDir($this, $this->options);
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
        ExtractCommandOptions::getDownloadsDir($input, $this->options);
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

        $this->printAvailableFullDiffList(
            $this->getAvailableFullDiffList(
                $this->getDatasetIndexList(
                    $this->getExtractList(
                        $selected,
                        $this->options->downloadsDir,
                        $this->options->downloadsFileExt,
                        'FullDiff'
                    ),
                    $this->getExtractList(
                        $selected,
                        $this->options->downloadsDir,
                        $this->options->indexFileExt,
                        'Full'
                    )
                )
            )
        );

        return static::SUCCESS;
    }


    /**
     * @param array<string,array{0:string,1:string,2:string}> $availableFullDiffs
     * @return void
     */
    private function printAvailableFullDiffList(array $availableFullDiffs): void
    {
        try {
            $out = FileIO::openFile('php://stdout', 'w');
            foreach ($availableFullDiffs as $availableFullDiff) {
                fputcsv($out, $availableFullDiff, ",", '"', '"', "\n");
            }
        } finally {
            if (is_resource($out ?? null)) {
                @fclose($out);
            }
            unset($out);
        }
    }


    /**
     * @param array<string,array<string,array{0:string,1:bool}>> $datasets
     * @return array<string,array{0:string,1:string,2:string}>
     */
    private function getAvailableFullDiffList(array $datasets): array
    {
        $availableFullDiffs = [];

        foreach ($datasets as $datasetName => $datasetIndexes) {
            if (count($datasetIndexes) > 1) {
                ksort($datasetIndexes);
                list($previousIndex,) = array_shift($datasetIndexes);
                foreach ($datasetIndexes as $timestamp => list($currentIndex, $hasFullDiff)) {
                    if ($hasFullDiff === false) {
                        $availableFullDiffs["{$datasetName}_{$timestamp}"] = [
                            "{$datasetName}_{$timestamp}_FullDiff",
                            $previousIndex,
                            $currentIndex
                        ];
                    }
                    $previousIndex = $currentIndex;
                }
            }
        }

        return $availableFullDiffs;
    }


    /**
     * @param array<string,string> $fullDiffs
     * @param array<string,string> $indexes
     * @return array<string,array<string,array{0:string,1:bool}>>
     */
    private function getDatasetIndexList(
        array $fullDiffs,
        array $indexes
    ): array {
        $datasets = [];

        foreach ($indexes as $indexPrefix => $indexName) {
            list(
                $datasetName,
                $date,
                $time
            ) = explode('_', $indexPrefix);

            if (!isset($datasets[$datasetName])) {
                $datasets[$datasetName] = [];
            }

            $datasets[$datasetName]["{$date}_{$time}"] = [
                $indexName,
                isset($fullDiffs[$indexPrefix])
            ];
        }

        return $datasets;
    }


    /**
     * @param string[] $selected
     * @param string $fileDir
     * @param string $fileExt
     * @param string $bdsType
     * @return array<string,string>
     */
    private function getExtractList(
        array $selected,
        string $fileDir,
        string $fileExt,
        string $bdsType
    ): array {
        return array_column(
            array_map(
                fn ($v) => $this->combineExtractParts($v),
                array_filter(
                    array_map(
                        fn ($v) => $this->splitExtractName($v),
                        array_keys(FileList::get($fileDir, $fileExt))
                    ),
                    fn ($v) => $this->filterExtracts($v, $selected, $bdsType)
                )
            ),
            0,
            1
        );
    }


    /**
     * @param array{0:string,1:string,2:string,3:string} $extractParts
     * @return array{0:string,1:string}
     */
    private function combineExtractParts(array $extractParts): array
    {
        return [
            $extractParts[0],
            "{$extractParts[1]}_{$extractParts[2]}"
        ];
    }


    /**
     * @param string $extractName
     * @return array{0:string,1:string,2:string,3:string}
     */
    private function splitExtractName(string $extractName): array
    {
        list(
            $datasetName,
            $date,
            $time,
            $type
        ) = explode('_', $extractName);

        return [
            $extractName,
            $datasetName,
            "{$date}_{$time}",
            $type
        ];
    }


    /**
     * @param array{0:string,1:string,2:string,3:string} $extractParts
     * @param string[] $selected
     * @param string $bdsType
     * @return bool
     */
    private function filterExtracts(
        array $extractParts,
        array $selected,
        string $bdsType
    ): bool {
        return (count($selected) < 1 || in_array($extractParts[1], $selected, true))
            && $extractParts[3] === $bdsType;
    }
}

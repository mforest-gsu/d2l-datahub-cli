<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Action;

use mjfk23\D2LAPI\DataHub\Model\BDSExtractInfo;
use mjfk23\D2LAPI\DataHub\Model\BDSInfo;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class GetAvailableExtractsAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param array<string, string> $downloadedExtracts
     * @param array<string, BDSInfo> $availableDatasets
     * @param bool $includeFull
     * @param bool $includeDiff
     * @return array<string, BDSExtractInfo>
     */
    public function __invoke(
        array &$downloadedExtracts,
        array &$availableDatasets,
        bool $includeFull,
        bool $includeDiff
    ): array {
        return $this->execute(
            $downloadedExtracts,
            $availableDatasets,
            $includeFull,
            $includeDiff
        );
    }


    /**
     * @param array<string, string> $downloadedExtracts
     * @param array<string, BDSInfo> $availableDatasets
     * @param bool $includeFull
     * @param bool $includeDiff
     * @return array<string, BDSExtractInfo>
     */
    public function execute(
        array &$downloadedExtracts,
        array &$availableDatasets,
        bool $includeFull,
        bool $includeDiff
    ): array {
        $start = microtime(true);

        try {
            $total = $full = $diff = 0;
            $extracts = [];

            foreach ($availableDatasets as $datasetName => $dataset) {
                list($totalAdded, $fullAdded, $diffAdded) = $this->addDatasetExtractsToList(
                    $datasetName,
                    $dataset,
                    $includeFull,
                    $includeDiff,
                    $downloadedExtracts,
                    $extracts
                );

                $full += $fullAdded;
                $diff += $diffAdded;
                $total += $totalAdded;
            }

            return $extracts;
        } finally {
            $this->logger?->info("Available extracts - " . $this->formatLogResults([
                "Extracts" => $total,
                "Selected" => $full + $diff,
                "Full" => $full,
                "Diff" => $diff,
                "Elapsed" => $this->getElapsedTime($start)
            ]));
        }
    }


    /**
     * @param string $datasetName
     * @param BDSInfo $dataset
     * @param bool $includeFull
     * @param bool $includeDiff
     * @param array<string, string> $downloaded
     * @param array<string, BDSExtractInfo> $extracts
     * @return array{0:int, 1:int, 2:int}
     */
    private function addDatasetExtractsToList(
        string $datasetName,
        BDSInfo $dataset,
        bool $includeFull,
        bool $includeDiff,
        array &$downloaded,
        array &$extracts
    ): array {
        $start = microtime(true);
        $this->logger?->debug("Fetch available extracts: {$datasetName}");

        list($fullTotal, $full) = $this->addExtractsToList(
            $datasetName,
            $includeFull ? ($dataset->Full?->Extracts ?? null) : null,
            $downloaded,
            $extracts
        );

        list($diffTotal, $diff) = $this->addExtractsToList(
            $datasetName,
            $includeDiff ? ($dataset->Differential?->Extracts ?? null) : null,
            $downloaded,
            $extracts
        );

        $this->logger?->debug($this->formatLogResults([
            "Dataset" => $datasetName,
            "Extracts" => $fullTotal + $diffTotal,
            "Selected" => $full + $diff,
            "Full" => $full,
            "Diff" => $diff,
            "Elapsed" => $this->getElapsedTime($start)
        ]));
        return [$fullTotal + $diffTotal, $full, $diff];
    }



    /**
     * @param string $datasetName
     * @param BDSExtractInfo[]|null $extractsToAdd
     * @param array<string, string> $downloaded
     * @param array<string, BDSExtractInfo> $extracts
     * @return array{0:int, 1:int}
     */
    private function addExtractsToList(
        string $datasetName,
        array|null $extractsToAdd,
        array &$downloaded,
        array &$extracts
    ): array {
        $total = $added = 0;

        if (is_array($extractsToAdd)) {
            foreach ($extractsToAdd as $extract) {
                $extractName = $this->getExtractName($datasetName, $extract);
                if (!isset($downloaded[$extractName])) {
                    $extracts[$extractName] = $extract;
                    $added++;
                }
                $total++;
            }
        }

        return [$total, $added];
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

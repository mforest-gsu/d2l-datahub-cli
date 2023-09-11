<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Action;

use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class GetDatasetsToUploadAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param bool $includeFull
     * @param bool $includeDiff
     * @param array<string,string> $selectedDatasets
     * @param array<string,string> $processedExtracts
     * @param array<string,string> $uploadedExtracts
     * @return array<string,array<string,string>>
     */
    public function __invoke(
        bool $includeFull,
        bool $includeDiff,
        array &$selectedDatasets,
        array &$processedExtracts,
        array &$uploadedExtracts
    ): array {
        return $this->execute(
            $includeFull,
            $includeDiff,
            $selectedDatasets,
            $processedExtracts,
            $uploadedExtracts
        );
    }


    /**
     * @param bool $includeFull
     * @param bool $includeDiff
     * @param array<string,string> $selectedDatasets
     * @param array<string,string> $processedExtracts
     * @param array<string,string> $uploadedExtracts
     * @return array<string,array<string,string>>
     */
    public function execute(
        bool $includeFull,
        bool $includeDiff,
        array &$selectedDatasets,
        array &$processedExtracts,
        array &$uploadedExtracts
    ): array {
        $start = microtime(true);
        $full = $diff = 0;
        $fullExtracts = [];
        $extractsToUpload = [];

        try {
            foreach (array_keys($uploadedExtracts) as $extractName) {
                if (str_contains($extractName, '_Full')) {
                    list($bdsName) = explode("_", $extractName);
                    if ($extractName > ($fullExtracts[$bdsName] ?? '')) {
                        $fullExtracts[$bdsName] = $extractName;
                    }
                }
            }

            if ($includeFull) {
                foreach (array_keys($processedExtracts) as $extractName) {
                    if (str_contains($extractName, '_Full')) {
                        list($bdsName) = explode("_", $extractName);
                        if ($extractName > ($fullExtracts[$bdsName] ?? '')) {
                            $fullExtracts[$bdsName] = $extractName;
                        }
                    }
                }
            }

            foreach ($processedExtracts as $extractName => $extractPath) {
                list($bdsName,,, $bdsType) = explode("_", $extractName);
                if (isset($uploadedExtracts[$extractName])) {
                    continue;
                }
                if (!in_array($bdsName, $selectedDatasets, true)) {
                    continue;
                }
                if (!($includeFull && $bdsType === 'Full') && !($includeDiff && $bdsType === 'Diff')) {
                    continue;
                }
                if ($extractName < ($fullExtracts[$bdsName] ?? '')) {
                    continue;
                }

                if (!isset($extractsToUpload[$bdsName])) {
                    $extractsToUpload[$bdsName] = [];
                }
                $extractsToUpload[$bdsName][$extractName] = $extractPath;
                if ($bdsType === 'Full') {
                    $full++;
                } else {
                    $diff++;
                }
            }

            return $extractsToUpload;
        } finally {
            $this->logger?->info("Datasets to upload - " . $this->formatLogResults([
                "Datasets" => count($extractsToUpload),
                "Extracts" => $full + $diff,
                "Full" => $full,
                "Diff" => $diff,
                "Elapsed" => $this->getElapsedTime($start)
            ]));
        }
    }
}

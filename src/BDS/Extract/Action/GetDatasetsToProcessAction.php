<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Action;

use D2L\DataHub\BDS\Schema\Action\GetDatasetSchemaAction;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class GetDatasetsToProcessAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param GetDatasetSchemaAction $getDatasetSchemaAction
     */
    public function __construct(private GetDatasetSchemaAction $getDatasetSchemaAction)
    {
    }


    /**
     * @param bool $includeFull
     * @param bool $includeDiff
     * @param array<string,string> $selectedDatasets
     * @param array<string,string> $downloadedExtracts
     * @param array<string,string> $processedExtracts
     * @return array<string,array{0:BDSSchema,1:array<string,string>}>
     */
    public function __invoke(
        bool $includeFull,
        bool $includeDiff,
        array &$selectedDatasets,
        array &$downloadedExtracts,
        array &$processedExtracts
    ): array {
        return $this->execute(
            $includeFull,
            $includeDiff,
            $selectedDatasets,
            $downloadedExtracts,
            $processedExtracts
        );
    }


    /**
     * @param bool $includeFull
     * @param bool $includeDiff
     * @param array<string,string> $selectedDatasets
     * @param array<string,string> $downloadedExtracts
     * @param array<string,string> $processedExtracts
     * @return array<string,array{0:BDSSchema,1:array<string,string>}>
     */
    public function execute(
        bool $includeFull,
        bool $includeDiff,
        array &$selectedDatasets,
        array &$downloadedExtracts,
        array &$processedExtracts
    ): array {
        $start = microtime(true);
        $full = $diff = 0;
        $extractsToProcess = [];

        try {
            foreach ($downloadedExtracts as $extractName => $extractPath) {
                list($bdsName,,, $bdsType) = explode("_", $extractName);
                if (isset($processedExtracts[$extractName])) {
                    continue;
                }
                if (!in_array($bdsName, $selectedDatasets, true)) {
                    continue;
                }
                if (!($includeFull && $bdsType === 'Full') && !($includeDiff && $bdsType === 'Diff')) {
                    continue;
                }

                if (!isset($extractsToProcess[$bdsName])) {
                    $extractsToProcess[$bdsName] = [
                        $this->getDatasetSchemaAction->execute($bdsName),
                        []
                    ];
                }
                $extractsToProcess[$bdsName][1][$extractName] = $extractPath;
                if ($bdsType === 'Full') {
                    $full++;
                } else {
                    $diff++;
                }
            }

            return $extractsToProcess;
        } finally {
            $this->logger?->info("Datasets to process - " . $this->formatLogResults([
                "Datasets" => count($extractsToProcess),
                "Extracts" => $full + $diff,
                "Full" => $full,
                "Diff" => $diff,
                "Elapsed" => $this->getElapsedTime($start)
            ]));
        }
    }
}

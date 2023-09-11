<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Action;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\Utils\FileIO;
use mjfk23\D2LAPI\DataHub\DataHubAPI;
use mjfk23\D2LAPI\DataHub\Model\BDSExtractInfo;
use mjfk23\D2LAPI\DataHub\Model\BDSInfo;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class GetAvailableDatasetsAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param BDSExtractOptions $options
     * @param DataHubAPI $dataHubAPI
     */
    public function __construct(
        private BDSExtractOptions $options,
        private DataHubAPI $dataHubAPI
    ) {
    }


    /**
     * @param string[] $datasetList
     * @return array<string, BDSInfo>
     */
    public function __invoke(array &$datasetList): array
    {
        return $this->execute($datasetList);
    }


    /**
     * @param string[] $selectedDatasets
     * @return array<string, BDSInfo>
     */
    public function execute(array &$selectedDatasets): array
    {
        $start = microtime(true);
        $this->logger?->info(str_pad("", 51, "="));
        $this->logger?->info("Fetch available datasets");

        $datasets = $this->getBDS();
        list($total, $selected) = $this->filterBDS($datasets, $selectedDatasets);

        $this->logger?->info($this->formatLogResults([
            "Datasets" => $total,
            "Selected" => $selected,
            "Elapsed" => $this->getElapsedTime($start)
        ]));
        return $datasets;
    }


    /**
     * @return BDSInfo[]
     */
    private function getBDS(): array
    {
        $cachePath = "{$this->options->downloadsDir}/bds.json";
        $cacheContents = is_file($cachePath) ? FileIO::getContents($cachePath) : false;
        $bdsCache = is_string($cacheContents) ? FileIO::jsonDecode($cacheContents) : null;
        $bdsCacheExpires = is_array($bdsCache) ? ($bdsCache['expires'] ?? null) : null;
        $bdsCacheItems = is_array($bdsCache) ? ($bdsCache['items'] ?? null) : null;

        if (is_array($bdsCacheItems) && is_int($bdsCacheExpires) && $bdsCacheExpires > time()) {
            $bds = array_map(
                fn ($v) => BDSInfo::create($v),
                $bdsCacheItems
            );
        } else {
            $bds = $this->dataHubAPI->getBDS();

            FileIO::putContents($cachePath, FileIO::jsonEncode([
                'expires' => time() + 600,
                'items' => $bds,
            ]));
        }

        return $bds;
    }


    /**
     * @param BDSInfo[] $datasets
     * @param string[] $selected
     * @return array{0:int, 1:int}
     */
    private function filterBDS(
        array &$datasets,
        array &$selected
    ): array {
        $total = count($datasets);

        $datasets = array_map(
            fn ($v) => [$v, str_replace(' ', '', $v->Name)],
            $this->getBDS()
        );
        if (count($selected) > 0) {
            $datasets = array_filter(
                $datasets,
                fn ($v) => in_array($v[1], $selected, true)
            );
        }
        $datasets = array_column($datasets, 0, 1);

        return [$total, count($datasets)];
    }
}

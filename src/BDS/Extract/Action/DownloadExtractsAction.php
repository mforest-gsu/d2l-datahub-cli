<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Action;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use mjfk23\D2LAPI\DataHub\DataHubAPI;
use mjfk23\D2LAPI\DataHub\Model\BDSExtractInfo;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class DownloadExtractsAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param DataHubAPI $dataHubAPI
     */
    public function __construct(
        private BDSExtractOptions $options,
        private DataHubAPI $dataHubAPI
    ) {
    }


    /**
     * @param array<string, BDSExtractInfo> $extracts
     * @return void
     */
    public function __invoke(array &$extracts): void
    {
        $this->execute($extracts);
    }


    /**
     * @param array<string, BDSExtractInfo> $extracts
     * @return void
     */
    public function execute(array &$extracts): void
    {
        $start = microtime(true);
        $this->logger?->info(str_pad("", 51, "="));
        $this->logger?->info("Download extracts");

        $full = $diff = 0;
        foreach ($extracts as $extractName => $extract) {
            $this->downloadExtract($extractName, $extract);
            if ($extract->BdsType === 'Full') {
                $full++;
            } else {
                $diff++;
            }
        }

        $this->logger?->info($this->formatLogResults([
            "Extracts" => count($extracts),
            "Full" => $full,
            "Diff" => $diff,
            "Elapsed" => $this->getElapsedTime($start)
        ]));
    }


    /**
     * @param string $extractName
     * @param BDSExtractInfo $extract
     * @return void
     */
    private function downloadExtract(
        string $extractName,
        BDSExtractInfo $extract
    ): void {
        $start = microtime(true);
        $bytes = $this->dataHubAPI->downloadBDSExtract(
            $extract,
            "{$this->options->downloadsDir}/{$extractName}.zip"
        );
        $this->logger?->info($this->formatLogResults([
            "Extract" => $extractName,
            "Size" => $bytes,
            "Elapsed" => $this->getElapsedTime($start)
        ]));
    }
}

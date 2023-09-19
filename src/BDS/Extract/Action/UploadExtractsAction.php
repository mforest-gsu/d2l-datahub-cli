<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Action;

use D2L\DataHub\BDS\Extract\ExtractUploader;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class UploadExtractsAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param array<string,array<string,string>> $datasetsToUpload
     * @param ExtractUploader $extractUploader
     * @return void
     */
    public function __invoke(
        array &$datasetsToUpload,
        ExtractUploader $extractUploader
    ): void {
        $this->execute(
            $datasetsToUpload,
            $extractUploader
        );
    }


    /**
     * @param array<string,array<string,string>> $datasetsToUpload
     * @param ExtractUploader $extractUploader
     * @return void
     */
    public function execute(
        array &$datasetsToUpload,
        ExtractUploader $extractUploader
    ): void {
        $start = microtime(true);
        $full = $diff = 0;

        try {
            foreach ($datasetsToUpload as $extracts) {
                foreach (array_keys($extracts) as $extractName) {
                    $extractStart = microtime(true);
                    list(,,, $bdsType) = explode("_", $extractName);

                    $extractUploader->uploadExtract($extractName);

                    if ($bdsType === 'Full') {
                        $full++;
                    } else {
                        $diff++;
                    }

                    $this->logger?->info($this->formatLogResults([
                        "Extract" => $extractName,
                        "Elapsed" => $this->getElapsedTime($extractStart)
                    ]));
                }
            }
        } finally {
            $this->logger?->info("Upload extracts - " . $this->formatLogResults([
                "Datasets" => count($datasetsToUpload),
                "Extracts" => $full + $diff,
                "Full" => $full,
                "Diff" => $diff,
                "Elapsed" => $this->getElapsedTime($start)
            ]));
        }
    }
}

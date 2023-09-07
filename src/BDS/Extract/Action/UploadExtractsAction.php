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
        $this->logger?->info(str_pad("", 51, "="));
        $this->logger?->info("Upload extracts");

        $full = $diff = 0;
        foreach ($datasetsToUpload as $extracts) {
            /** @var array<string,string> $extracts */
            foreach ($extracts as $extractName => $extractPath) {
                $extractStart = microtime(true);
                list(,,, $bdsType) = explode("_", $extractName);

                $extractUploader->uploadExtract($extractName, $extractPath);

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

        $this->logger?->info($this->formatLogResults([
            "Datasets" => count($datasetsToUpload),
            "Extracts" => $full + $diff,
            "Full" => $full,
            "Diff" => $diff,
            "Elapsed" => $this->getElapsedTime($start)
        ]));
    }
}

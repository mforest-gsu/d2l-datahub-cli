<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Action;

use D2L\DataHub\BDS\Extract\ExtractProcessor;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class ProcessExtractsAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param array<string,array{0:BDSSchema,1:array<string,string>}> $datasetsToProcess
     * @param ExtractProcessor $extractProcessor
     * @return void
     */
    public function __invoke(
        array &$datasetsToProcess,
        ExtractProcessor $extractProcessor
    ): void {
        $this->execute(
            $datasetsToProcess,
            $extractProcessor
        );
    }


    /**
     * @param array<string,array{0:BDSSchema,1:array<string,string>}> $datasetsToProcess
     * @param ExtractProcessor $extractProcessor
     * @return void
     */
    public function execute(
        array &$datasetsToProcess,
        ExtractProcessor $extractProcessor
    ): void {
        $start = microtime(true);
        $this->logger?->info(str_pad("", 51, "="));
        $this->logger?->info("Process extracts");

        $full = $diff = 0;
        foreach ($datasetsToProcess as list($schema, $extracts)) {
            foreach ($extracts as $extractName => $extractPath) {
                $extractStart = microtime(true);
                list(,,, $bdsType) = explode("_", $extractName);

                $records = $extractProcessor->processExtract(
                    $schema,
                    $bdsType,
                    $extractName,
                    $extractPath
                );

                if ($bdsType === 'Full') {
                    $full++;
                } else {
                    $diff++;
                }

                $this->logger?->info($this->formatLogResults([
                    "Extract" => $extractName,
                    "Records" => $records,
                    "Elapsed" => $this->getElapsedTime($extractStart)
                ]));
            }
        }

        $this->logger?->info($this->formatLogResults([
            "Datasets" => count($datasetsToProcess),
            "Extracts" => $full + $diff,
            "Full" => $full,
            "Diff" => $diff,
            "Elapsed" => $this->getElapsedTime($start)
        ]));
    }
}

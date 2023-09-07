<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Action;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Extract\Utils\FileList;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class GetDownloadedExtractsAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param BDSExtractOptions $options
     */
    public function __construct(private BDSExtractOptions $options)
    {
    }


    /**
     * @return array<string, string>
     */
    public function __invoke(): array
    {
        return $this->execute();
    }


    /**
     * @return array<string, string>
     */
    public function execute(): array
    {
        $start = microtime(true);
        $this->logger?->info(str_pad("", 51, "="));
        $this->logger?->info("Fetch list of downloaded extracts");

        $extracts = FileList::get($this->options->downloadsDir, '.zip');

        $this->logger?->info($this->formatLogResults([
            "Extracts" => count($extracts),
            "Elapsed" => $this->getElapsedTime($start)
        ]));
        return $extracts;
    }
}

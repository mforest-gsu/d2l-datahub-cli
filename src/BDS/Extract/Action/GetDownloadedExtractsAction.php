<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Action;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\Utils\FileList;
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

        try {
            $extracts = FileList::get($this->options->downloadsDir, '.zip');
            return $extracts;
        } finally {
            $this->logger?->info("Downloaded extracts - " . $this->formatLogResults([
                "Extracts" => count($extracts ?? []),
                "Elapsed" => $this->getElapsedTime($start)
            ]));
        }
    }
}

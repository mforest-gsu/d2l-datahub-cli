<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Action;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Extract\Utils\FileList;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class GetUploadedExtractsAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param BDSExtractOptions $options
     */
    public function __construct(private BDSExtractOptions $options)
    {
    }


    /**
     * @param string $fileExtension
     * @return array<string, string>
     */
    public function __invoke(string $fileExtension): array
    {
        return $this->execute($fileExtension);
    }


    /**
     * @param string $fileExtension
     * @return array<string, string>
     */
    public function execute(string $fileExtension = '.txt'): array
    {
        $start = microtime(true);
        $this->logger?->info(str_pad("", 51, "="));
        $this->logger?->info("Fetch list of uploaded extracts");

        $extracts = FileList::get($this->options->uploadsDir, $fileExtension);

        $this->logger?->info($this->formatLogResults([
            "Extracts" => count($extracts),
            "Elapsed" => $this->getElapsedTime($start)
        ]));
        return $extracts;
    }
}

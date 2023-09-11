<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Action;

use D2L\DataHub\BDS\Schema\ModuleDownloader;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class DownloadModulesAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param ModuleDownloader $moduleDownloader
     */
    public function __construct(private ModuleDownloader $moduleDownloader)
    {
    }


    /**
     * @param array<int,string> $modules
     * @return void
     */
    public function __invoke(array &$modules): void
    {
        $this->execute($modules);
    }


    /**
     * @param array<int,string> $modules
     * @return void
     */
    public function execute(array &$modules): void
    {
        $start = microtime(true);

        try {
            foreach ($modules as $moduleName) {
                $this->downloadModule($moduleName);
            }
        } finally {
            $this->logger?->info("Download modules - " . $this->formatLogResults([
                "Modules" => count($modules),
                "Elapsed" => $this->getElapsedTime($start)
            ]));
        }
    }


    /**
     * @param string $moduleName
     * @return void
     */
    private function downloadModule(string $moduleName): void
    {
        $start = microtime(true);
        $this->logger?->debug("Download module: {$moduleName}");

        $bytes = $this->moduleDownloader->download($moduleName);

        $this->logger?->debug($this->formatLogResults([
            "Module" => $moduleName,
            "Bytes" => $bytes,
            "Elapsed" => $this->getElapsedTime($start)
        ]));
    }
}

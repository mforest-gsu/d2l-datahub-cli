<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Action;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\ModuleParser;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class GenerateDatasetSchemaAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param ModuleParser $moduleParser
     */
    public function __construct(private ModuleParser $moduleParser)
    {
    }


    /**
     * @param array<int,string> $modules
     * @return array<string,BDSSchema>
     */
    public function __invoke(array &$modules): array
    {
        return $this->execute($modules);
    }


    /**
     * @param array<int,string> $modules
     * @return array<string,BDSSchema>
     */
    public function execute(array &$modules): array
    {
        $start = microtime(true);
        $this->logger?->info(str_pad("", 51, "="));
        $this->logger?->info("Generate dataset schema");

        $datasets = [];
        foreach ($modules as $moduleName) {
            $datasets += $this->generateModuleDatasetSchema($moduleName);
        }
        ksort($datasets);

        $this->logger?->info($this->formatLogResults([
            "Datasets" => count($datasets),
            "Elapsed" => $this->getElapsedTime($start)
        ]));
        return $datasets;
    }


    /**
     * @param string $moduleName
     * @return array<string,BDSSchema>
     */
    private function generateModuleDatasetSchema(string $moduleName): array
    {
        $start = microtime(true);
        $this->logger?->debug("Generating dataset schema from module: {$moduleName}");

        $moduleDatasets = $this->moduleParser->parse($moduleName);

        $this->logger?->debug($this->formatLogResults([
            "Module" => $moduleName,
            "Datasets" => count($moduleDatasets),
            "Elapsed" => $this->getElapsedTime($start)
        ]));

        return $moduleDatasets;
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Action;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\BDS\Schema\TableGenerator;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class GenerateSQLTableSchemaAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param BDSSchemaOptions $options
     * @param (callable(BDSSchemaOptions $options): TableGenerator) $tableGenFactory
     */
    public function __construct(
        private BDSSchemaOptions $options,
        private mixed $tableGenFactory
    ) {
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
     * @param array<string,BDSSchema> $datasetSchema
     * @return void
     */
    public function execute(array &$datasetSchema): void
    {
        $tableGenerator = ($this->tableGenFactory)($this->options);

        $start = microtime(true);
        $this->logger?->info(str_pad("", 51, "="));
        $this->logger?->info("Generate table schema: " . $tableGenerator::class);

        foreach ($datasetSchema as $dataset) {
            $this->generateTable($tableGenerator, $dataset);
        }

        $this->logger?->info($this->formatLogResults([
            "Tables" => count($datasetSchema),
            "Elapsed" => $this->getElapsedTime($start)
        ]));
    }


    /**
     * @param TableGenerator $tableGenerator
     * @param BDSSchema $dataset
     * @return void
     */
    private function generateTable(
        TableGenerator $tableGenerator,
        BDSSchema $dataset
    ): void {
        $start = microtime(true);
        $this->logger?->debug("Generate SQL table: {$dataset->name}");

        $bytes = $tableGenerator->generate($dataset);

        $this->logger?->debug($this->formatLogResults([
            "Table" => $dataset->name,
            "Bytes" => $bytes,
            "Elapsed" => $this->getElapsedTime($start)
        ]));
    }
}

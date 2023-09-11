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
        $start = microtime(true);

        try {
            $tableGenerator = ($this->tableGenFactory)($this->options);
            foreach ($datasetSchema as $dataset) {
                $this->generateTable($tableGenerator, $dataset);
            }
        } finally {
            $this->logger?->info("Generate table schema - " . $this->formatLogResults([
                "Generator" => is_object($tableGenerator ?? null) ? $tableGenerator::class : '',
                "Tables" => count($datasetSchema),
                "Elapsed" => $this->getElapsedTime($start)
            ]));
        }
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

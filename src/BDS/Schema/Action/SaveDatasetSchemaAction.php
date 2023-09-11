<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Action;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\Utils\FileIO;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class SaveDatasetSchemaAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param BDSSchemaOptions $options
     */
    public function __construct(private BDSSchemaOptions $options)
    {
    }


    /**
     * @param array<string,BDSSchema> $datasetSchema
     * @return void
     */
    public function __invoke(array &$datasetSchema): void
    {
        $this->execute($datasetSchema);
    }


    /**
     * @param array<string,BDSSchema> $datasetSchema
     * @return void
     */
    public function execute(array &$datasetSchema): void
    {
        $start = microtime(true);
        $this->logger?->info(str_pad("", 51, "="));
        $this->logger?->info("Save dataset schema");

        foreach ($datasetSchema as $dataset) {
            $this->saveDataset(
                str_replace(' ', '', $dataset->name),
                ["{$dataset->name}" => $dataset]
            );
        }
        $this->saveDataset(
            'all',
            $datasetSchema
        );

        $this->logger?->info($this->formatLogResults([
            "Datasets" => count($datasetSchema),
            "Elapsed" => $this->getElapsedTime($start)
        ]));
    }


    /**
     * @param string $fileName
     * @param array<string,BDSSchema> $datasetSchema
     * @return void
     */
    private function saveDataset(
        string $fileName,
        array $datasetSchema
    ): void {
        $start = microtime(true);
        $schemaFile = "{$this->options->datasetsDir}/{$fileName}.json";
        $schemaFileContents = FileIO::jsonEncode($datasetSchema);
        $bytes = FileIO::putContents($schemaFile, $schemaFileContents);
        $this->logger?->debug($this->formatLogResults([
            "Path" => $schemaFile,
            "Bytes" => $bytes,
            "Elapsed" => $this->getElapsedTime($start)
        ]));
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractProcessor;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Extract\Model\BDSExtractProcessInfo;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaNameMap;
use D2L\DataHub\Utils\FileIO;

abstract class ExtractProcessor
{
    /**
     * @param BDSExtractOptions $options
     * @param BDSSchemaNameMap $nameMap
     */
    public function __construct(
        protected BDSExtractOptions $options,
        protected BDSSchemaNameMap $nameMap
    ) {
    }


    /**
     * @param BDSSchema $schema
     * @param string $bdsType
     * @param string $extractName
     * @return BDSExtractProcessInfo
     */
    public function processExtract(
        BDSSchema $schema,
        string $bdsType,
        string $extractName
    ): BDSExtractProcessInfo {
        try {
            $processInfo = new BDSExtractProcessInfo(
                schema: $schema,
                bdsType: $bdsType,
                extractName: $extractName,
                tableName: '',
                columns: [],
                formatters: []
            );

            list($zipFile, $csvFile) = $this->openSourceFile($processInfo);
            $processInfo->tableName = $this->getTableName($processInfo);
            $processInfo->columns = $this->getSourceFileColumns($processInfo, $csvFile);
            $processInfo->formatters = $this->getFormatters($processInfo);
            list($processInfo->totalRows, $processInfo->files) = match ($bdsType) {
                'FullDiff' => $this->processFullDiff($processInfo, $csvFile),
                'Full' => $this->processFull($processInfo, $csvFile),
                'Diff' => $this->processDiff($processInfo, $csvFile),
                default => throw new \RuntimeException('Invalid dataset type')
            };

            $this->saveProcessInfo($processInfo);

            return $processInfo;
        } finally {
            if (is_resource($csvFile ?? null)) {
                @fclose($csvFile);
            }
            if (($zipFile ?? null) instanceof \ZipArchive) {
                @$zipFile->close();
            }
            unset($csvFile, $zipFile);
        }
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @return string
     */
    protected function getSourceFilePath(BDSExtractProcessInfo $processInfo): string
    {
        return "{$this->options->downloadsDir}/{$processInfo->extractName}{$this->options->downloadsFileExt}";
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @return string
     */
    protected function getProcessFilePath(BDSExtractProcessInfo $processInfo): string
    {
        return "{$this->options->processDir}/{$processInfo->extractName}{$this->options->processFileExt}";
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @return string
     */
    protected function getTableName(BDSExtractProcessInfo $processInfo): string
    {
        return $this->nameMap->getTableName($processInfo->schema->name);
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @return array{0:\ZipArchive,1:resource}
     */
    protected function openSourceFile(BDSExtractProcessInfo $processInfo): array
    {
        return FileIO::openZipFile($this->getSourceFilePath($processInfo));
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @param resource $csvFile
     * @return array<int,BDSSchemaColumn>
     */
    protected function getSourceFileColumns(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array {
        // Get schema columns
        $schemaColumns = array_column($processInfo->schema->columns, null, 'name');

        // Get extract columns
        $csvColumns = fgetcsv(stream: $csvFile, escape: '"');
        if (!is_array($csvColumns)) {
            throw new \RuntimeException("Error reading columns from source file");
        }

        // Map extract columns to schema columns
        return array_column(
            array_filter(
                array_map(
                    fn ($v, $k) => [$schemaColumns[$v] ?? null, intval($k)],
                    array_values($csvColumns),
                    array_keys($csvColumns)
                ),
                fn ($v) => $v[0] instanceof BDSSchemaColumn
            ),
            0,
            1
        );
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @return array<int,(callable(string $v): string)>
     */
    protected function getFormatters(BDSExtractProcessInfo $processInfo): array
    {
        return array_map(
            fn (BDSSchemaColumn $column): \Closure => $this->getFormatter(
                $processInfo,
                $column
            ),
            $processInfo->columns
        );
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @return int
     */
    protected function saveProcessInfo(BDSExtractProcessInfo $processInfo): int
    {
        return FileIO::putContents(
            $this->getProcessFilePath($processInfo),
            FileIO::jsonEncode($processInfo)
        );
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @param resource $csvFile
     * @return array{0:int,1:array<string,string>}
     */
    abstract protected function processFullDiff(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array;


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @param resource $csvFile
     * @return array{0:int,1:array<string,string>}
     */
    abstract protected function processFull(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array;


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @param resource $csvFile
     * @return array{0:int,1:array<string,string>}
     */
    abstract protected function processDiff(
        BDSExtractProcessInfo $processInfo,
        mixed $csvFile
    ): array;


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @param BDSSchemaColumn $column
     * @return (\Closure(string $v): string)
     */
    abstract protected function getFormatter(
        BDSExtractProcessInfo $processInfo,
        BDSSchemaColumn $column
    ): \Closure;
}

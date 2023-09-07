<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaNameMap;

abstract class ExtractProcessor
{
    public static string $processFileExtension = '.sql';


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
     * @param string $extractPath
     * @param string $extractPath
     * @return int
     */
    abstract public function processExtract(
        BDSSchema $schema,
        string $bdsType,
        string $extractName,
        string $extractPath
    ): int;


    /**
     * @param string $extractName
     * @param ?string $fileExt
     * @return string
     */
    protected function getProcessPath(
        string $extractName,
        ?string $fileExt = null
    ): string {
        return "{$this->options->processDir}/{$extractName}" . ($fileExt ?? static::$processFileExtension);
    }


    /**
     * @param BDSSchema $schema
     * @return string
     */
    protected function getTableName(BDSSchema $schema): string
    {
        return $this->nameMap->getTableName($schema->name);
    }


    /**
     * @param string $extractPath
     * @return array{0:\ZipArchive,1:resource}
     */
    protected function openExtractFile(string $extractPath): array
    {
        $zipFile = new \ZipArchive();
        if ($zipFile->open($extractPath) !== true) {
            throw new \RuntimeException("Unable to open file: {$extractPath}");
        }

        $extractFile = $zipFile->getStream(strval($zipFile->getNameIndex(0)));
        if (!is_resource($extractFile)) {
            throw new \RuntimeException("Unable to open file: {$extractPath}");
        }

        // Strip byte order mark (BOM)
        fread($extractFile, 3);

        return [$zipFile, $extractFile];
    }


    /**
     * @param string $processPath
     * @return resource
     */
    protected function openProcessFile(string $processPath): mixed
    {
        $processFile = gzopen($processPath, 'w9');
        return is_resource($processFile)
            ? $processFile
            : throw new \RuntimeException();
    }


    /**
     * @param BDSSchema $schema
     * @param resource $extractFile
     * @return array<int,BDSSchemaColumn>
     */
    protected function getColumns(
        BDSSchema $schema,
        mixed $extractFile
    ): array {
        // Get schema columns
        $schemaColumns = array_column(
            $schema->columns,
            null,
            'name'
        );

        $columns = fgetcsv(stream: $extractFile, escape: '"');
        if (!is_array($columns)) {
            throw new \RuntimeException();
        }

        return array_column(
            array_filter(
                array_map(
                    fn ($v, $k) => [$schemaColumns[$v] ?? null, intval($k)],
                    array_values($columns),
                    array_keys($columns)
                ),
                fn ($v) => $v[0] instanceof BDSSchemaColumn
            ),
            0,
            1
        );
    }
}

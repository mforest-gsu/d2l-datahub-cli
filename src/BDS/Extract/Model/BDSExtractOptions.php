<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Model;

use D2L\DataHub\BDS\Extract\ExtractProcessor\OracleExtractProcessor;
use D2L\DataHub\BDS\Extract\ExtractUploader\OracleExtractUploader;
use mjfk23\Container\ArrayValue;
use mjfk23\Container\ObjectFactory;

class BDSExtractOptions
{
    /**
     * @param mixed $values
     * @return self
     */
    public static function create(mixed $values): self
    {
        $appDir = ArrayValue::getStringNull($values, 'APP_DIR') ?? __DIR__ . '/../../../../';
        $workDir = ArrayValue::getStringNull($values, 'WORK_DIR') ?? "{$appDir}/work";
        $extractsDir = ArrayValue::getStringNull($values, 'EXTRACT_DIR') ?? "{$workDir}/extracts";
        $uploadsDatabase = ArrayValue::getStringNull($values, 'EXTRACT_UPLOADS_DATABASE') ?? '';

        return ObjectFactory::createObject($values, self::class, fn (array $values): self => new self(
            appDir: $appDir,
            availableDir: ArrayValue::getStringNull($values, 'EXTRACT_AVAILABLE_DIR')
                ?? "{$extractsDir}/available",
            downloadsDir: ArrayValue::getStringNull($values, 'EXTRACT_DOWNLOADS_DIR')
                ?? "{$extractsDir}/downloads",
            processDir: ArrayValue::getStringNull($values, 'EXTRACT_PROCESS_DIR')
                ?? "{$extractsDir}/process/oracle",
            processorClass: ArrayValue::getStringNull($values, 'EXTRACT_PROCESSOR_CLASS')
                ?? OracleExtractProcessor::class,
            uploadsDir: ArrayValue::getStringNull($values, 'EXTRACT_UPLOADS_DIR')
                ?? "{$extractsDir}/uploads/{$uploadsDatabase}",
            uploadsDatabase: $uploadsDatabase,
            uploaderClass: ArrayValue::getStringNull($values, 'EXTRACT_UPLOADER_CLASS')
                ?? OracleExtractUploader::class
        ));
    }


    /**
     * @param string $appDir
     * @param string $availableDir
     * @param string $downloadsDir
     * @param string $processDir
     * @param string $processorClass
     * @param string $uploadsDir
     * @param string $uploadsDatabase
     * @param string $uploaderClass
     * @param string $availableFileExt
     * @param string $downloadsFileExt
     * @param string $processFileExt
     * @param string $uploadsFileExt
     */
    public function __construct(
        public string $appDir,
        public string $availableDir,
        public string $downloadsDir,
        public string $processDir,
        public string $processorClass,
        public string $uploadsDir,
        public string $uploadsDatabase,
        public string $uploaderClass,
        public string $availableFileExt = '.json',
        public string $downloadsFileExt = '.zip',
        public string $processFileExt = '.json',
        public string $uploadsFileExt = '.json',
    ) {
    }
}

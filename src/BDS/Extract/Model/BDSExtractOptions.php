<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Model;

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
        $extractsDir = ArrayValue::getStringNull($values, 'BDS_EXTRACT_DIR') ?? "{$workDir}/extracts";

        return ObjectFactory::createObject($values, self::class, fn (array $values): self => new self(
            appDir: $appDir,
            logDir: ArrayValue::getStringNull($values, 'LOG_DIR') ?? "{$appDir}/logs",
            downloadsDir: ArrayValue::getStringNull($values, 'BDS_EXTRACT_DOWNLOADS_DIR') ?? "{$extractsDir}/downloads",
            processDir: ArrayValue::getStringNull($values, 'BDS_EXTRACT_PROCESS_DIR') ?? "{$extractsDir}/process",
            uploadsDir: ArrayValue::getStringNull($values, 'BDS_EXTRACT_UPLOADS_DIR') ?? "{$extractsDir}/uploads",
            extractProcessorClass: ArrayValue::getStringNull($values, 'BDS_EXTRACT_EXTRACT_PROCESSOR_CLASS')
                ?? 'D2L\DataHub\BDS\Extract\ExtractProcessor\MySQLExtractProcessor',
            extractUploaderClass: ArrayValue::getStringNull($values, 'BDS_EXTRACT_EXTRACT_UPLOADER_CLASS')
                ?? 'D2L\DataHub\BDS\Extract\ExtractProcessor\MySQLExtractUploader',
            extractDBName: ArrayValue::getStringNull($values, 'BDS_EXTRACT_DB_NAME')
                ?? '',
        ));
    }


    /**
     * @param string $appDir
     * @param string $logDir
     * @param string $downloadsDir
     * @param string $processDir
     * @param string $uploadsDir
     * @param string $extractProcessorClass
     * @param string $extractUploaderClass
     * @param string $extractDBName
     */
    public function __construct(
        public string $appDir,
        public string $logDir,
        public string $downloadsDir,
        public string $processDir,
        public string $uploadsDir,
        public string $extractProcessorClass,
        public string $extractUploaderClass,
        public string $extractDBName,
    ) {
    }
}

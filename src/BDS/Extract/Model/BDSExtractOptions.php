<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Model;

class BDSExtractOptions
{
    /**
     * @param string $logDir
     * @param string $downloadsDir
     * @param string $processDir
     * @param string $uploadsDir
     * @param string $extractProcessorClass
     * @param string $extractUploaderClass
     */
    public function __construct(
        public string $logDir,
        public string $downloadsDir,
        public string $processDir,
        public string $uploadsDir,
        public string $extractProcessorClass,
        public string $extractUploaderClass
    ) {
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractUploader;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Extract\Model\BDSExtractProcessInfo;
use D2L\DataHub\BDS\Extract\Model\BDSProcessInfo;
use D2L\DataHub\Utils\FileIO;

abstract class ExtractUploader
{
    /**
     * @param BDSExtractOptions $options
     */
    public function __construct(protected BDSExtractOptions $options)
    {
    }


    /**
     * @param BDSExtractProcessInfo $processInfo
     * @return int
     */
    abstract public function uploadExtract(BDSExtractProcessInfo $processInfo): int;
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;

abstract class ExtractUploader
{
    public static string $processFileExtension = '.sql';
    public static string $uploadFileExtension = '.txt';
    public static string $uploaderScriptName = '';


    /**
     * @param BDSExtractOptions $options
     */
    public function __construct(protected BDSExtractOptions $options)
    {
    }


    /**
     * @param string $extractName
     * @param string $extractPath
     * @return void
     */
    abstract public function uploadExtract(
        string $extractName,
        string $extractPath
    ): void;
}

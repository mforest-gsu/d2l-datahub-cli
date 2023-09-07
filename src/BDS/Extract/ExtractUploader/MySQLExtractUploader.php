<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractUploader;

use D2L\DataHub\BDS\Extract\ExtractUploader;

class MySQLExtractUploader extends ExtractUploader
{
    public static string $processFileExtension = '.sql.gz';


    /**
     * @param string $extractName
     * @param string $extractPath
     * @return void
     */
    public function uploadExtract(
        string $extractName,
        string $extractPath
    ): void {
    }
}

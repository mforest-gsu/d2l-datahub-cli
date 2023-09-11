<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractUploader;

use D2L\DataHub\BDS\Extract\ExtractUploader;

class OracleExtractUploader extends ExtractUploader
{
    public static string $processFileExtension = '.par';


    /**
     * @param string $extractName
     * @param string $extractPath
     * @return void
     */
    public function uploadExtract(
        string $extractName,
        string $extractPath
    ): void {
        $processPath = dirname($extractPath);
        exec(implode(" ", [
            escapeshellcmd("{$this->options->appDir}/bin/uploaders/oracle-upload"),
            escapeshellarg($this->options->extractDBName),
            escapeshellarg("{$processPath}/{$extractName}.par"),
            escapeshellarg("{$processPath}/{$extractName}.dat"),
            escapeshellarg("{$processPath}/{$extractName}.sql"),
            ">> /dev/null 2>&1"
        ]));
    }
}

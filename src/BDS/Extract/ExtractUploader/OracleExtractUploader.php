<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractUploader;

use D2L\DataHub\BDS\Extract\ExtractUploader;

class OracleExtractUploader extends ExtractUploader
{
    public static string $processFileExtension = '.ctl';


    /**
     * @param string $extractName
     * @return void
     */
    public function uploadExtract(
        string $extractName
    ): void {
        exec(implode(" ", [
            escapeshellcmd("{$this->options->appDir}/bin/uploaders/oracle-upload"),
            escapeshellarg($this->options->extractDBName),
            escapeshellarg($extractName),
            escapeshellarg($this->options->processDir),
            escapeshellarg($this->options->uploadsDir),
            ">> /dev/null 2>&1"
        ]));
    }
}

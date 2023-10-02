<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractUploader;

use D2L\DataHub\BDS\Extract\Model\BDSExtractProcessInfo;
use D2L\DataHub\Utils\FileIO;

class MySQLExtractUploader extends ExtractUploader
{
    /**
     * @inheritdoc
     */
    public function uploadExtract(BDSExtractProcessInfo $processInfo): int
    {
        $start = date('c');

        $uploaderScriptPath = "{$this->options->appDir}/bin/utils/mysql-upload";
        $dataFilePath = $processInfo->files['data'] ?? '';
        $totalRows = strval($processInfo->totalRows);
        $uploadsDatabase = $this->options->uploadsDatabase;
        $uploadOutFilePath = "{$this->options->uploadsDir}/{$processInfo->extractName}.out";
        $uploadInfoFilePath = sprintf(
            "%s/%s%s",
            $this->options->uploadsDir,
            $processInfo->extractName,
            $this->options->uploadsFileExt
        );

        if (!file_exists($uploaderScriptPath)) {
            throw new \RuntimeException("Uploader script not found: {$uploaderScriptPath}");
        }
        if ($dataFilePath === '' || !file_exists($dataFilePath)) {
            throw new \RuntimeException("Data file not found: {$dataFilePath}");
        }
        if ($uploadsDatabase === '') {
            throw new \RuntimeException("Missing database parameter");
        }
        if ($uploadOutFilePath === $uploadInfoFilePath) {
            throw new \RuntimeException("Out log file and info file cannot be the same");
        }

        $cmd = sprintf(
            "%s %s %s %s > %s 2>&1",
            escapeshellcmd($uploaderScriptPath),
            escapeshellarg($dataFilePath),
            escapeshellarg($totalRows),
            escapeshellarg($uploadsDatabase),
            escapeshellarg($uploadOutFilePath)
        );
        $output = [];
        $returnCode = 0;
        exec($cmd, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \RuntimeException("Return code: {$returnCode}");
        }
        if (!file_exists($uploadOutFilePath)) {
            throw new \RuntimeException("Output file not found: {$uploadOutFilePath}");
        }

        FileIO::putContents(
            $uploadInfoFilePath,
            FileIO::jsonEncode([
                'class' => self::class,
                'command' => $cmd,
                'started' => $start,
                'finished' => date('c')
            ])
        );

        return $processInfo->totalRows;
    }
}

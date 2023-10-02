<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractUploader;

use D2L\DataHub\BDS\Extract\Model\BDSExtractProcessInfo;
use D2L\DataHub\BDS\Extract\Model\BDSProcessInfo;
use D2L\DataHub\Utils\FileIO;

class OracleExtractUploader extends ExtractUploader
{
    /**
     * @inheritdoc
     */
    public function uploadExtract(BDSExtractProcessInfo $processInfo): int
    {
        $start = date('c');

        $uploaderScriptPath = "{$this->options->appDir}/bin/utils/oracle-upload";
        $ctlFilePath = $processInfo->files['ctl'] ?? '';
        $dataFilePath = $processInfo->files['data'] ?? '';
        $sqlFilePath = $processInfo->files['sql'] ?? '';
        $totalRows = strval($processInfo->totalRows);
        $uploadsDatabase = $this->options->uploadsDatabase;
        $sqlldrLogFilePath = "{$this->options->uploadsDir}/{$processInfo->extractName}.sqlldr.log";
        $sqlldrBadFilePath = "{$this->options->uploadsDir}/{$processInfo->extractName}.sqlldr.bad";
        $sqlldrDisFilePath = "{$this->options->uploadsDir}/{$processInfo->extractName}.sqlldr.dis";
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
        if ($ctlFilePath === '' || !file_exists($ctlFilePath)) {
            throw new \RuntimeException("Control file not found: {$ctlFilePath}");
        }
        if ($dataFilePath === '' || !file_exists($dataFilePath)) {
            throw new \RuntimeException("Data file not found: {$dataFilePath}");
        }
        if ($sqlFilePath === '' || !file_exists($sqlFilePath)) {
            throw new \RuntimeException("SQL file not found: {$sqlFilePath}");
        }
        if ($uploadsDatabase === '') {
            throw new \RuntimeException("Missing database parameter");
        }
        if ($uploadOutFilePath === $uploadInfoFilePath) {
            throw new \RuntimeException("Out log file and info file cannot be the same");
        }

        $cmd = sprintf(
            "%s %s %s %s %s %s %s %s %s > %s 2>&1",
            escapeshellcmd($uploaderScriptPath),
            escapeshellarg($ctlFilePath),
            escapeshellarg($dataFilePath),
            escapeshellarg($sqlFilePath),
            escapeshellarg($totalRows),
            escapeshellarg($uploadsDatabase),
            escapeshellarg($sqlldrLogFilePath),
            escapeshellarg($sqlldrBadFilePath),
            escapeshellarg($sqlldrDisFilePath),
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
        if (!file_exists($sqlldrLogFilePath)) {
            throw new \RuntimeException("SQL*Loader log file not found: {$sqlldrLogFilePath}");
        }
        if (file_exists($sqlldrBadFilePath)) {
            throw new \RuntimeException("SQL*Loader bad file exists: {$sqlldrBadFilePath}");
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

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract;

use D2L\DataHub\BDS\Extract\Command\ProcessExtractsCommand;
use D2L\DataHub\BDS\Extract\ExtractProcessor\MySQLExtractProcessor;
use D2L\DataHub\BDS\Extract\ExtractUploader\MySQLExtractUploader;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use mjfk23\Container\DefinitionSource;
use mjfk23\Container\Env;
use Psr\Container\ContainerInterface;

class BDSExtractDefinitions extends DefinitionSource
{
    /**
     * @inheritdoc
     */
    protected function createDefinitions(Env $env): array
    {
        $logDir = $env['LOG_DIR'] ?? null;
        $downloadsDir = $env['BDS_EXTRACT_DOWNLOADS_DIR'] ?? null;
        $processDir = $env['BDS_EXTRACT_PROCESS_DIR'] ?? null;
        $uploadsDir = $env['BDS_EXTRACT_UPLOADS_DIR'] ?? null;
        $extractProcessorClass = $env['BDS_EXTRACT_EXTRACT_PROCESSOR_CLASS'] ?? null;
        $extractUploaderClass = $env['BDS_EXTRACT_EXTRACT_UPLOADER_CLASS'] ?? null;

        $logDir = is_string($logDir) ? $logDir : "{$env->appDir}/logs";
        $downloadsDir = is_string($downloadsDir) ? $downloadsDir : "{$env->appDir}/work/extracts/downloads";
        $processDir = is_string($processDir) ? $processDir : "{$env->appDir}/work/extracts/process";
        $uploadsDir = is_string($uploadsDir) ? $uploadsDir : "{$env->appDir}/work/extracts/uploads";
        $extractProcessorClass = is_string($extractProcessorClass)
            ? $extractProcessorClass
            : MySQLExtractProcessor::class;
        $extractUploaderClass = is_string($extractUploaderClass)
            ? $extractUploaderClass
            : MySQLExtractUploader::class;

        return [
            BDSExtractOptions::class => static::autowire(null, [
                'logDir' => $logDir,
                'downloadsDir' => $downloadsDir,
                'processDir' => $processDir,
                'uploadsDir' => $uploadsDir,
                'extractProcessorClass' => $extractProcessorClass,
                'extractUploaderClass' => $extractUploaderClass,
            ]),
            ProcessExtractsCommand::class => static::autowire(null, [
                'extractProcessorFactory' => static::factory(function (ContainerInterface $c) {
                    return function (BDSExtractOptions $options) use ($c): ExtractProcessor {
                        $extractProcessor = $c->get($options->extractProcessorClass);
                        if (!$extractProcessor instanceof ExtractProcessor) {
                            throw new \RuntimeException();
                        }
                        return $extractProcessor;
                    };
                })
            ])
        ];
    }
}

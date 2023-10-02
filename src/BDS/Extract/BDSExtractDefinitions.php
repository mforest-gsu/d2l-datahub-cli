<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract;

use D2L\DataHub\BDS\Extract\Command\ProcessExtractCommand;
use D2L\DataHub\BDS\Extract\Command\UploadExtractCommand;
use D2L\DataHub\BDS\Extract\ExtractProcessor\ExtractProcessor;
use D2L\DataHub\BDS\Extract\ExtractUploader\ExtractUploader;
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
        return [
            BDSExtractOptions::class => static::factory(fn() => BDSExtractOptions::create((array)$env)),
            ProcessExtractCommand::class => static::autowire(null, [
                'processorFactory' => static::factory(function (ContainerInterface $c) {
                    return function (BDSExtractOptions $options) use ($c): ExtractProcessor {
                        $processor = $c->get($options->processorClass);
                        if (!$processor instanceof ExtractProcessor) {
                            throw new \RuntimeException("Error creating instance of ExtractProcessor");
                        }
                        return $processor;
                    };
                })
            ]),
            UploadExtractCommand::class => static::autowire(null, [
                'uploaderFactory' => static::factory(function (ContainerInterface $c) {
                    return function (BDSExtractOptions $options) use ($c): ExtractUploader {
                        $uploader = $c->get($options->uploaderClass);
                        if (!$uploader instanceof ExtractUploader) {
                            throw new \RuntimeException("Error creating instance of ExtractUploader");
                        }
                        return $uploader;
                    };
                })
            ])
        ];
    }
}

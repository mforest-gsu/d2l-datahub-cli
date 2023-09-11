<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract;

use D2L\DataHub\BDS\Extract\Command\ProcessExtractsCommand;
use D2L\DataHub\BDS\Extract\Command\UploadExtractsCommand;
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
            ]),
            UploadExtractsCommand::class => static::autowire(null, [
                'extractUploaderFactory' => static::factory(function (ContainerInterface $c) {
                    return function (BDSExtractOptions $options) use ($c): ExtractUploader {
                        $extractUploader = $c->get($options->extractUploaderClass);
                        if (!$extractUploader instanceof ExtractUploader) {
                            throw new \RuntimeException();
                        }
                        return $extractUploader;
                    };
                })
            ])
        ];
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema;

use D2L\DataHub\BDS\Schema\Command\GenerateTablesCommand;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\BDS\Schema\TableGenerator\TableGenerator;
use mjfk23\Container\DefinitionSource;
use mjfk23\Container\Env;
use Psr\Container\ContainerInterface;

class BDSSchemaDefinitions extends DefinitionSource
{
    /**
     * @inheritdoc
     */
    protected function createDefinitions(Env $env): array
    {
        return [
            BDSSchemaOptions::class => static::factory(fn() => BDSSchemaOptions::create((array)$env)),
            GenerateTablesCommand::class => static::autowire(null, [
                'tableGenFactory' => static::factory(function (ContainerInterface $c) {
                    return function (BDSSchemaOptions $options) use ($c): TableGenerator {
                        $tableGenerator = $c->get($options->tableGenClass);
                        if (!$tableGenerator instanceof TableGenerator) {
                            throw new \RuntimeException("Not an instance of " . TableGenerator::class);
                        }
                        return $tableGenerator;
                    };
                })
            ])
        ];
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub;

use mjfk23\Console\ApplicationInvoker;
use mjfk23\Container\DefinitionSource;
use mjfk23\Container\Env;
use mjfk23\D2LAPI\D2LAPIDefinitionSource;
use mjfk23\HttpClient\HttpClientDefinitionSource;
use mjfk23\PDO\PDODefinitionSource;

class App
{
    public static function run(string $appDir): void
    {
        $env = new Env($appDir, __NAMESPACE__);

        $defSources = array_values(
            [
                PDODefinitionSource::class => new PDODefinitionSource($env),
                HttpClientDefinitionSource::class => new HttpClientDefinitionSource($env),
                D2LAPIDefinitionSource::class => new D2LAPIDefinitionSource($env)
            ]
            + array_map(
                fn (\ReflectionClass $classDef) => $classDef->newInstance($env),
                array_filter(
                    $env->classRepo->classes,
                    fn (\ReflectionClass $classDef) => $classDef->isInstantiable()
                        && $classDef->isSubclassOf(DefinitionSource::class)
                )
            )
        );

        $exitCode = ApplicationInvoker::invoke($env, $defSources);

        exit($exitCode);
    }
}

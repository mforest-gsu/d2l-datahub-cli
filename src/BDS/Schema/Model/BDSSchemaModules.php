<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Model;

use mjfk23\Container\ArrayValue;

class BDSSchemaModules
{
    /** @var array<string,string>|null $moduleValues */
    private array|null $moduleValues = null;

    /** @var string[]|null $moduleNames */
    private array|null $moduleNames = null;


    /**
     * @param BDSSchemaOptions $options
     */
    public function __construct(private BDSSchemaOptions $options)
    {
    }


    /**
     * @return array<string,string>
     */
    protected function getModuleValues(): array
    {
        if ($this->moduleValues === null) {
            $this->moduleValues = ArrayValue::getStringArray($this->options->modulesFile);
            $this->moduleNames = null;
        }
        return $this->moduleValues;
    }


    /**
     * @return string[]
     */
    public function getModules(): array
    {
        if ($this->moduleNames === null) {
            $this->moduleNames = array_keys($this->getModuleValues());
        }
        return $this->moduleNames;
    }


    /**
     * @param string $moduleName
     * @return ?string
     */
    public function getModuleURL(string $moduleName): ?string
    {
        return $this->getModuleValues()[$moduleName] ?? null;
    }
}

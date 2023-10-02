<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Model;

use mjfk23\Container\ArrayValue;

class BDSSchemaNameMap
{
    /** @var \ArrayObject<string,string>|null $schemaToAPIMap */
    private \ArrayObject|null $schemaToAPIMap = null;

    /** @var \ArrayObject<string,string>|null $apiToSchemaMap */
    private \ArrayObject|null $apiToSchemaMap = null;

    /** @var \ArrayObject<string,string>|null $apiToTableMap */
    private \ArrayObject|null $apiToTableMap = null;

    /** @var \ArrayObject<string,string>|null $tableToAPIMap */
    private \ArrayObject|null $tableToAPIMap = null;


    /**
     * @param BDSSchemaOptions $options
     */
    public function __construct(private BDSSchemaOptions $options)
    {
    }


    /**
     * @param string $name
     * @return string
     */
    public function getSchemaName(string $name): string
    {
        return $this->getAPIToSchemaMap()[$name]
            ?? $this->getAPIToSchemaMap()[$this->getTableToAPIMap()[$name] ?? '']
            ?? (
                isset($this->getSchemaToAPIMap()[$name])
                ? $name
                : throw new \RuntimeException("Unable to get schema name: {$name}")
            );
    }


    /**
     * @param string $name
     * @return string
     */
    public function getAPIName(string $name): string
    {
        return $this->getSchemaToAPIMap()[$name]
            ?? $this->getTableToAPIMap()[$name]
            ?? (
                isset($this->getAPIToSchemaMap()[$name])
                ? $name
                : throw new \RuntimeException("Unable to find match: {$name}")
            );
    }


    /**
     * @param string $name
     * @return string
     */
    public function getTableName(string $name): string
    {
        return $this->getAPIToTableMap()[$name]
            ?? $this->getAPIToTableMap()[$this->getSchemaToAPIMap()[$name] ?? '']
            ?? (
                isset($this->getTableToAPIMap()[$name])
                ? $name
                : throw new \RuntimeException("Unable to get table name: {$name}")
            );
    }


    /**
     * @return \ArrayObject<string,string>
     */
    protected function getSchemaToAPIMap(): \ArrayObject
    {
        if ($this->schemaToAPIMap === null) {
            $this->schemaToAPIMap = new \ArrayObject(
                ArrayValue::getStringArray($this->options->apiMapFile)
            );
        }
        return $this->schemaToAPIMap;
    }


    /**
     * @return \ArrayObject<string,string>
     */
    protected function getAPIToTableMap(): \ArrayObject
    {
        if ($this->apiToTableMap === null) {
            $this->apiToTableMap = new \ArrayObject(
                ArrayValue::getStringArray($this->options->tableMapFile)
            );
        }
        return $this->apiToTableMap;
    }


    /**
     * @return \ArrayObject<string,string>
     */
    protected function getAPIToSchemaMap(): \ArrayObject
    {
        if ($this->apiToSchemaMap === null) {
            $this->apiToSchemaMap = new \ArrayObject(
                array_flip(
                    ArrayValue::getStringArray($this->options->apiMapFile)
                )
            );
        }
        return $this->apiToSchemaMap;
    }


    /**
     * @return \ArrayObject<string,string>
     */
    protected function getTableToAPIMap(): \ArrayObject
    {
        if ($this->tableToAPIMap === null) {
            $this->tableToAPIMap = new \ArrayObject(
                array_flip(
                    ArrayValue::getStringArray($this->options->tableMapFile)
                )
            );
        }
        return $this->tableToAPIMap;
    }
}

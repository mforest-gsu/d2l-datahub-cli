<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Model;

use mjfk23\Container\ArrayValue;
use mjfk23\Container\ObjectFactory;

class BDSSchemaColumn
{
    /**
     * @param mixed $values
     * @return self
     */
    public static function create(mixed $values): self
    {
        return ObjectFactory::createObject($values, self::class, fn (array $values): self => new self(
            name: ArrayValue::getString($values, 'name'),
            description: ArrayValue::getString($values, 'description'),
            dataType: ArrayValue::getString($values, 'dataType'),
            columnSize: ArrayValue::getString($values, 'columnSize'),
            key: ArrayValue::getStringNull($values, 'key') ?? implode(",", [
                (ArrayValue::getBoolNull($values, 'pk') ?? false) === true ? 'PK' : '',
                (ArrayValue::getBoolNull($values, 'fk') ?? false) === true ? 'FK' : ''
            ]),
            versionHistory: ArrayValue::getString($values, 'versionHistory')
        ));
    }


    public string $name;
    public string $description;
    public string $dataType;
    public string $columnSize;
    public bool $canBeNull;
    public bool $pk;
    public bool $fk;
    public string $versionHistory;


    /**
     * @param string $name
     * @param string $description
     * @param string $dataType
     * @param string $columnSize
     * @param string $key
     * @param string $versionHistory
     */
    public function __construct(
        string $name = '',
        string $description = '',
        string $dataType = '',
        string $columnSize = '',
        string $key = '',
        string $versionHistory = '',
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->dataType = $dataType;
        $this->columnSize = $columnSize;
        $this->canBeNull = str_contains($this->description, 'Field can be null');
        $this->pk = str_contains($key, 'PK');
        $this->fk = str_contains($key, 'FK');
        $this->versionHistory = $versionHistory;
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Model;

use mjfk23\Container\ArrayValue;
use mjfk23\Container\ObjectFactory;

class BDSSchema
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
            columns: array_map(
                fn($col) => BDSSchemaColumn::create($col),
                ArrayValue::getArray($values, 'columns')
            )
        ));
    }


    /**
     * @param string $name
     * @param string $description
     * @param array<int,BDSSchemaColumn> $columns
     */
    public function __construct(
        public string $name = '',
        public string $description = '',
        public array $columns = []
    ) {
    }
}

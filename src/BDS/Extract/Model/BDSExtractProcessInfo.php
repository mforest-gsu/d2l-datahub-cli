<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Model;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use mjfk23\Container\ArrayValue;
use mjfk23\Container\ObjectFactory;

class BDSExtractProcessInfo
{
    /**
     * @param mixed $values
     * @return self
     */
    public static function create(mixed $values): self
    {
        return ObjectFactory::createObject($values, self::class, fn (array $values): self => new self(
            schema: BDSSchema::create(ArrayValue::getArray($values, 'schema')),
            bdsType: ArrayValue::getString($values, 'bdsType'),
            extractName: ArrayValue::getString($values, 'extractName'),
            tableName: ArrayValue::getString($values, 'tableName'),
            columns: array_map(fn($v) => BDSSchemaColumn::create($v), ArrayValue::getArray($values, 'columns')),
            formatters: [],
            totalRows: ArrayValue::getIntNull($values, 'totalRows') ?? 0,
            files: ArrayValue::getStringArray(ArrayValue::getArrayNull($values, 'files') ?? []),
            datasetName: ArrayValue::getStringNull($values, 'datasetName') ?? '',
        ));
    }


    /**
     * @param BDSSchema $schema
     * @param string $bdsType
     * @param string $extractName
     * @param string $datasetName
     * @param string $tableName
     * @param BDSSchemaColumn[] $columns
     * @param array<int,(callable(string $v):string)> $formatters
     * @param int $totalRows
     * @param array<string,string> $files
     */
    public function __construct(
        public BDSSchema $schema,
        public string $bdsType,
        public string $extractName,
        public string $tableName,
        public array $columns,
        public array $formatters = [],
        public int $totalRows = 0,
        public array $files = [],
        public string $datasetName = '',
    ) {
        if ($this->datasetName === '') {
            $this->datasetName = str_replace(' ', '', $this->schema->name);
        }
    }
}

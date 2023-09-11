<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Action;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\Utils\FileIO;
use mjfk23\Logger\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

class GetDatasetSchemaAction implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * @param BDSSchemaOptions $options
     */
    public function __construct(private BDSSchemaOptions $options)
    {
    }


    /**
     * @param string $bdsName
     * @return BDSSchema
     */
    public function __invoke(string $bdsName): BDSSchema
    {
        return $this->execute($bdsName);
    }


    /**
     * @param string $bdsName
     * @return BDSSchema
     */
    public function execute(string $bdsName): BDSSchema
    {
        $bdsSchemaPath = "{$this->options->datasetsDir}/{$bdsName}.json";
        $bdsSchemaContents = is_file($bdsSchemaPath) ? FileIO::getContents($bdsSchemaPath) : false;
        $bdsSchemaContents = is_string($bdsSchemaContents) ? FileIO::jsonDecode($bdsSchemaContents) : null;
        if (!is_array($bdsSchemaContents)) {
            throw new \RuntimeException();
        }
        $bdsSchemaValues = reset($bdsSchemaContents);
        if (!is_array($bdsSchemaValues)) {
            throw new \RuntimeException();
        }
        return BDSSchema::create($bdsSchemaValues);
    }
}

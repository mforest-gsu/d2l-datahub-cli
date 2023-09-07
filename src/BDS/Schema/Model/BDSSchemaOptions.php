<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Model;

class BDSSchemaOptions
{
    /**
     * @param string $schemaDir
     * @param string $datasetsDir
     * @param string $modulesDir
     * @param string $tablesDir
     * @param string $tableGenClass
     */
    public function __construct(
        public string $schemaDir,
        public string $datasetsDir,
        public string $modulesDir,
        public string $tablesDir,
        public string $modulesFile,
        public string $apiMapFile,
        public string $tableMapFile,
        public string $tableGenClass
    ) {
    }
}

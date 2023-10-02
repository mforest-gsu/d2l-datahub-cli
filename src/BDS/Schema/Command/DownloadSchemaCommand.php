<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema\Command;

use D2L\DataHub\BDS\Schema\Model\BDSSchemaModules;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\BDS\Schema\ModuleDownloader;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'schema:download')]
class DownloadSchemaCommand extends Command
{
    /**
     * @param BDSSchemaOptions $options
     * @param BDSSchemaModules $modules
     * @param ModuleDownloader $moduleDownloader
     */
    public function __construct(
        private BDSSchemaOptions $options,
        private BDSSchemaModules $modules,
        private ModuleDownloader $moduleDownloader
    ) {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        SchemaCommandOptions::configModulesDir($this, $this->options);
        SchemaCommandOptions::configModuleFile($this, $this->options);
        $this
            ->addArgument(
                name: 'module',
                mode: InputOption::VALUE_OPTIONAL,
                description: 'Module to download'
            );
    }


    /**
     * @param InputInterface $input
     * @return array{0:string[]}
     */
    protected function collectInputs(InputInterface $input): array
    {
        SchemaCommandOptions::getModulesDir($input, $this->options);
        SchemaCommandOptions::getModulesFile($input, $this->options);
        $modules = $this->getArgumentArray(
            $input,
            'module',
            $this->modules->getModules()
        );
        if (count($modules) < 1) {
            $modules = $this->modules->getModules();
        }

        return [$modules];
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        list($modules) = $this->collectInputs($input);

        $bytes = 0;
        foreach ($modules as $moduleName) {
            $bytes += $this->downloadModule($moduleName);
        }

        return static::SUCCESS;
    }


    /**
     * @param string $moduleName
     * @return int
     */
    private function downloadModule(string $moduleName): int
    {
        $start = microtime(true);

        $bytes = $this->moduleDownloader->download($moduleName);

        $this->logger?->info("<Download Schema> " . $this->formatLogResults([
            "Module" => $moduleName,
            "Size" => $bytes,
            "Elapsed" => $this->getElapsedTime($start)
        ]));

        return $bytes;
    }
}

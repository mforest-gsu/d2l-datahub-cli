<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Schema\Command\SchemaCommandOptions;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'extracts:gen:index')]
class GenerateIndexCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     * @param BDSSchemaOptions $schemaOptions
     */
    public function __construct(
        private BDSExtractOptions $options,
        private BDSSchemaOptions $schemaOptions
    ) {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        SchemaCommandOptions::configDatasetsDir($this, $this->schemaOptions);
        ExtractCommandOptions::configDownloadsDir($this, $this->options);
        ExtractCommandOptions::configExtract($this);
    }


    /**
     * @param InputInterface $input
     * @return array{0:string}
     */
    protected function collectInputs(InputInterface $input): array
    {
        SchemaCommandOptions::getDatasetsDir($input, $this->schemaOptions);
        ExtractCommandOptions::getDownloadsDir($input, $this->options);
        list($extractName,, $bdsType) = ExtractCommandOptions::getExtract($input);
        if ($bdsType !== 'Full') {
            throw new \RuntimeException("Invalid dataset type");
        }
        return [$extractName];
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
        list($extractName) = $this->collectInputs($input);

        try {
            list($returnCode, $cmdOutput) = $this->execGenFullExtractIndex($extractName);
        } catch (\Throwable $t) {
            throw new \RuntimeException(
                "Unable to generate index for extract: '{$extractName}'",
                0,
                $t
            );
        }

        if ($returnCode !== static::SUCCESS) {
            if ($cmdOutput !== "") {
                $output->writeln($cmdOutput);
            }

            throw new \RuntimeException(sprintf(
                "Unable to generate index for extract: '%s', return code is %s",
                $extractName,
                $returnCode
            ));
        }

        $this->logger?->info(sprintf(
            '%s - %s',
            $input->__toString(),
            $this->formatLogResults([
                "Extract" => $extractName
            ])
        ));

        return static::SUCCESS;
    }


    /**
     * @param string $extractName
     * @return array{0:int, 1:string}
     */
    private function execGenFullExtractIndex(string $extractName): array
    {
        $cmd = sprintf(
            "%s/bin/utils/gen-full-extract-index",
            $this->options->appDir
        );

        $consoleCmd = sprintf(
            "%s/bin/console --datasets-dir=%s",
            $this->options->appDir,
            $this->schemaOptions->datasetsDir
        );

        $output = [];
        $returnCode = 0;

        exec(
            sprintf(
                "%s %s %s %s",
                escapeshellcmd($cmd),
                escapeshellarg($consoleCmd),
                escapeshellarg($this->options->downloadsDir),
                escapeshellarg($extractName)
            ),
            $output,
            $returnCode
        );

        return [$returnCode, implode(PHP_EOL, $output)];
    }
}

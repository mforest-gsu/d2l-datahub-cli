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

        $cmdOutput = [];
        $returnCode = $this->execGenFullExtractIndex(
            sprintf(
                "%s/bin/utils/gen-full-extract-index",
                $this->options->appDir
            ),
            sprintf(
                "%s/bin/console --datasets-dir=%s",
                $this->options->appDir,
                $this->schemaOptions->datasetsDir
            ),
            $this->options->downloadsDir,
            $extractName,
            $cmdOutput
        );

        $cmdOutput = implode("\n", $cmdOutput);
        if ($cmdOutput !== "") {
            $output->writeln($cmdOutput);
        }

        $this->logger?->info("<Gen Full Extract Index> " . $this->formatLogResults([
            "Extract" => $extractName
        ]));

        return $returnCode;
    }


    /**
     * @param string $cmd
     * @param string $downloadsDir
     * @param string $extractName
     * @param string[] $output
     * @return int
     */
    private function execGenFullExtractIndex(
        string $cmd,
        string $consoleCmd,
        string $downloadsDir,
        string $extractName,
        array &$output = []
    ): int {
        $returnCode = 0;

        exec(
            sprintf(
                "%s %s %s %s",
                escapeshellcmd($cmd),
                escapeshellarg($consoleCmd),
                escapeshellarg($downloadsDir),
                escapeshellarg($extractName)
            ),
            $output,
            $returnCode
        );

        return $returnCode;
    }
}

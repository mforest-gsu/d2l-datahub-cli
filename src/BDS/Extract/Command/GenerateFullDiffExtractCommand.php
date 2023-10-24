<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Schema\Command\SchemaCommandOptions;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'extracts:gen:fulldiff')]
class GenerateFullDiffExtractCommand extends Command
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

        $this->addArgument(
            name: 'previous',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Previous full index'
        );
        $this->addArgument(
            name: 'current',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Current full index'
        );
        $this->addArgument(
            name: 'columns',
            mode: InputOption::VALUE_REQUIRED,
            description: 'FullDiff extract columns'
        );
    }


    /**
     * @param InputInterface $input
     * @return array{0:string,1:string,2:string,3:string,4:string}
     */
    protected function collectInputs(InputInterface $input): array
    {
        SchemaCommandOptions::getDatasetsDir($input, $this->schemaOptions);
        ExtractCommandOptions::getDownloadsDir($input, $this->options);

        list($extractName, $datasetName, $bdsType) = ExtractCommandOptions::getExtract($input);
        if ($bdsType !== 'FullDiff') {
            throw new \RuntimeException("Invalid dataset type");
        }

        $previousIndex = $input->getArgument('previous');
        if (!is_string($previousIndex)) {
            throw new \RuntimeException("Previous index not specified");
        }

        $currentIndex = $input->getArgument('current');
        if (!is_string($currentIndex)) {
            throw new \RuntimeException("Current index not specified");
        }

        $extractColumns = $input->getArgument('columns');
        if (!is_string($extractColumns)) {
            throw new \RuntimeException("Columns not specified");
        }

        return [
            $extractName,
            $datasetName,
            $previousIndex,
            $currentIndex,
            $extractColumns
        ];
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
        list(
            $extractName,
            $datasetName,
            $previousIndex,
            $currentIndex,
            $extractColumns
        ) = $this->collectInputs($input);

        try {
            $schema = ExtractCommandOptions::getSchema(sprintf(
                "%s/%s.json",
                $this->schemaOptions->datasetsDir,
                $datasetName
            ));
        } catch (\Throwable $t) {
            throw new \RuntimeException(
                "Unable to retrieve schema for dataset: '{$datasetName}'",
                0,
                $t
            );
        }

        try {
            $columns = implode(",", ExtractCommandOptions::filterExtractFields(
                explode(",", $extractColumns),
                ExtractCommandOptions::getKeyFieldNames($schema)
            ));

            if (strlen($columns) < 1) {
                throw new \RuntimeException("Extract must have at least one column");
            }
        } catch (\Throwable $t) {
            throw new \RuntimeException(
                "Unable to get columns for extract: '{$extractName}'",
                0,
                $t
            );
        }

        try {
            list($returnCode, $cmdOutput) = $this->execGenFullDiffExtract(
                $extractName,
                $previousIndex,
                $currentIndex,
                $columns
            );
        } catch (\Throwable $t) {
            throw new \RuntimeException(
                "Unable to generate fulldiff extract: '{$extractName}'",
                0,
                $t
            );
        }

        if ($returnCode !== static::SUCCESS) {
            if ($cmdOutput !== "") {
                $output->writeln($cmdOutput);
            }

            throw new \RuntimeException(sprintf(
                "Unable to generate fulldiff extract: '%s', return code is %s",
                $extractName,
                $returnCode
            ));
        }

        $this->logger?->info(sprintf(
            '%s - %s',
            $input->__toString(),
            $this->formatLogResults([
                "Extract" => $extractName,
                "Previous" => $previousIndex,
                "Current" => $currentIndex
            ])
        ));

        return static::SUCCESS;
    }


    /**
     * @param string $extractName
     * @param string $previousIndex
     * @param string $currentIndex
     * @param string $columns
     * @return array{0:int,1:string}
     */
    private function execGenFullDiffExtract(
        string $extractName,
        string $previousIndex,
        string $currentIndex,
        string $columns
    ): array {
        $cmd = sprintf("%s/bin/utils/gen-fulldiff-extract", $this->options->appDir);
        $extractPath = sprintf(
            "%s/%s%s",
            $this->options->downloadsDir,
            $extractName,
            $this->options->downloadsFileExt
        );
        $previousIndexPath = sprintf(
            "%s/%s%s",
            $this->options->downloadsDir,
            $previousIndex,
            $this->options->indexFileExt
        );
        $currentIndexPath = sprintf(
            "%s/%s%s",
            $this->options->downloadsDir,
            $currentIndex,
            $this->options->indexFileExt
        );

        $output = [];
        $returnCode = 0;

        exec(
            sprintf(
                "%s %s %s %s %s",
                escapeshellcmd($cmd),
                escapeshellarg($extractPath),
                escapeshellarg($previousIndexPath),
                escapeshellarg($currentIndexPath),
                escapeshellarg($columns)
            ),
            $output,
            $returnCode
        );

        return [$returnCode, implode(PHP_EOL, $output)];
    }
}

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
     * @return array{0:string,1:string,2:string,3:string}
     */
    protected function collectInputs(InputInterface $input): array
    {
        SchemaCommandOptions::getDatasetsDir($input, $this->schemaOptions);
        ExtractCommandOptions::getDownloadsDir($input, $this->options);

        list($fullDiff, $datasetName, $bdsType) = ExtractCommandOptions::getExtract($input);
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

        $fullDiffColumns = $input->getArgument('columns');
        if (!is_string($fullDiffColumns)) {
            throw new \RuntimeException("Columns not specified");
        }

        return [
            $fullDiff,
            $previousIndex,
            $currentIndex,
            implode(",", ExtractCommandOptions::filterExtractFields(
                explode(",", $fullDiffColumns),
                ExtractCommandOptions::getKeyFieldNames(
                    ExtractCommandOptions::getSchema(
                        sprintf(
                            "%s/%s.json",
                            $this->schemaOptions->datasetsDir,
                            $datasetName
                        )
                    )
                )
            ))
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
            $fullDiff,
            $previousIndex,
            $currentIndex,
            $fullDiffColumns
        ) = $this->collectInputs($input);

        $returnCode = $this->execGenFullDiffExtract(
            sprintf("%s/bin/utils/gen-fulldiff-extract", $this->options->appDir),
            sprintf("%s/%s%s", $this->options->downloadsDir, $fullDiff, $this->options->downloadsFileExt),
            sprintf("%s/%s%s", $this->options->downloadsDir, $previousIndex, $this->options->indexFileExt),
            sprintf("%s/%s%s", $this->options->downloadsDir, $currentIndex, $this->options->indexFileExt),
            $fullDiffColumns
        );

        $this->logger?->info("<Gen FullDiff Extract> " . $this->formatLogResults([
            "Extract" => $fullDiff,
            "Previous" => $previousIndex,
            "Current" => $currentIndex
        ]));

        return $returnCode;
    }


    /**
     * @param string $fullDiff
     * @param string $previousIndex
     * @param string $currentIndex
     * @param string $fullDiffColumns
     * @param string[] $output
     * @return int
     */
    private function execGenFullDiffExtract(
        string $cmd,
        string $fullDiff,
        string $previousIndex,
        string $currentIndex,
        string $fullDiffColumns,
        array &$output = []
    ): int {
        $returnCode = 0;

        exec(
            sprintf(
                "%s %s %s %s %s",
                escapeshellcmd($cmd),
                escapeshellarg($fullDiff),
                escapeshellarg($previousIndex),
                escapeshellarg($currentIndex),
                escapeshellarg($fullDiffColumns)
            ),
            $output,
            $returnCode
        );

        return $returnCode;
    }
}

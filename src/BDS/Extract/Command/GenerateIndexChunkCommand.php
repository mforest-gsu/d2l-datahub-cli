<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Schema\Command\SchemaCommandOptions;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\Utils\FileIO;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'extracts:gen:index-chunk')]
class GenerateIndexChunkCommand extends Command
{
    /**
     * @param BDSSchemaOptions $schemaOptions
     */
    public function __construct(private BDSSchemaOptions $schemaOptions)
    {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        SchemaCommandOptions::configDatasetsDir($this, $this->schemaOptions);
        ExtractCommandOptions::configExtract($this);

        $this->addArgument(
            name: 'extractColumns',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Extract column names'
        );
    }


    /**
     * @param InputInterface $input
     * @return array{0:int[]}
     */
    protected function collectInputs(InputInterface $input): array
    {
        SchemaCommandOptions::getDatasetsDir($input, $this->schemaOptions);

        list(, $datasetName, $bdsType) = ExtractCommandOptions::getExtract($input);
        if ($bdsType !== 'Full') {
            throw new \RuntimeException("Invalid dataset type");
        }

        $extractColumns = $input->getArgument('extractColumns');
        if (!is_string($extractColumns)) {
            throw new \RuntimeException("Extract columns not specified");
        }

        return [
            array_keys(
                ExtractCommandOptions::filterExtractFields(
                    explode(",", $extractColumns),
                    ExtractCommandOptions::getKeyFieldNames(
                        ExtractCommandOptions::getSchema(
                            sprintf(
                                "%s/%s.json",
                                $this->schemaOptions->datasetsDir,
                                $datasetName
                            )
                        )
                    )
                )
            )
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
        list($indexColumns) = $this->collectInputs($input);

        try {
            $in = FileIO::openFile("php://stdin", "r");
            $out = FileIO::openFile("php://stdout", "w");

            while ($row = fgetcsv(stream: $in, escape: '"')) {
                $newRow = [];
                foreach ($indexColumns as $i) {
                    $newRow[] = $row[$i] ?? '';
                }
                fputcsv($out, $newRow, ",", '"', '"', "\n");
            }
        } finally {
            if (is_resource($in ?? null)) {
                @fclose($in);
            }
            if (is_resource($out ?? null)) {
                @fclose($out);
            }
            unset($in, $out);
        }

        return static::SUCCESS;
    }
}

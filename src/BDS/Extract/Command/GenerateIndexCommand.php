<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Schema\Command\SchemaCommandOptions;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\Utils\FileIO;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'extracts:gen-index')]
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

        $this->addOption(
            name: 'show-header',
            description: 'Show column header'
        );

        $this->addOption(
            name: 'hide-rows',
            description: 'Hide rows'
        );

        $this->addArgument(
            name: 'extract',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Extract to generate index for'
        );
    }


    /**
     * @param InputInterface $input
     * @return array{0:BDSSchema,1:string,2:bool,3:bool}
     */
    protected function collectInputs(InputInterface $input): array
    {
        SchemaCommandOptions::getDatasetsDir($input, $this->schemaOptions);
        ExtractCommandOptions::getDownloadsDir($input, $this->options);

        list($extractName, $datasetName,) = ExtractCommandOptions::getExtract($input);

        return [
            $this->getDatasetSchema($datasetName),
            $extractName,
            $input->getOption('show-header') !== false,
            $input->getOption('hide-rows') === false,
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
            $schema,
            $extractName,
            $showHeader,
            $showRows
        ) = $this->collectInputs($input);

        try {
            list($zipFile, $csvFile, $columns) = $this->openSourceFile($schema, $extractName);

            // Open output data file
            $out = FileIO::openFile('php://stdout', 'w');

            if ($showHeader) {
                fwrite($out, "\xEF\xBB\xBF");
                fputcsv($out, array_map(fn($c) => $c->name, $columns), ",", '"', '"', "\n");
            }

            // For each row in extract, read key values and write to index file
            if ($showRows) {
                while ($row = fgetcsv(stream: $csvFile, escape: '"')) {
                    $newRow = [];
                    foreach ($row as $i => $v) {
                        if (isset($columns[$i])) {
                            $newRow[] = $v;
                        }
                    }
                    fputcsv($out, $newRow, ",", '"', '"', "\n");
                }
            }
        } finally {
            if (($zipFile ?? null) instanceof \ZipArchive) {
                @$zipFile->close();
            }
            if (is_resource($csvFile ?? null)) {
                @fclose($csvFile);
            }
            if (is_resource($out ?? null)) {
                @fclose($out);
            }
            unset($zipFile, $csvFile, $out);
        }

        return static::SUCCESS;
    }


    /**
     * @param string $datasetName
     * @return BDSSchema
     */
    public function getDatasetSchema(string $datasetName): BDSSchema
    {
        $schema = FileIO::jsonDecode(
            FileIO::getContents(
                "{$this->schemaOptions->datasetsDir}/{$datasetName}.json"
            )
        );
        return BDSSchema::create(reset($schema));
    }


    /**
     * @param BDSSchema $schema
     * @param string $extractName
     * @return array{0:\ZipArchive,1:resource,2:array<int,BDSSchemaColumn>}
     */
    private function openSourceFile(
        BDSSchema $schema,
        string $extractName
    ): array {
        list($zipFile, $csvFile) = FileIO::openZipFile(
            "{$this->options->downloadsDir}/{$extractName}{$this->options->downloadsFileExt}"
        );

        // Get schema columns
        $schemaColumns = array_column($schema->columns, null, 'name');

        // Get extract columns
        $csvColumns = fgetcsv(stream: $csvFile, escape: '"');
        if (!is_array($csvColumns)) {
            throw new \RuntimeException("Error reading columns from source file");
        }

        // Map extract columns to schema columns
        $columns = array_column(
            array_filter(
                array_map(
                    fn ($v, $k) => [$schemaColumns[$v] ?? null, intval($k)],
                    array_values($csvColumns),
                    array_keys($csvColumns)
                ),
                fn ($v) => $v[0] instanceof BDSSchemaColumn && $v[0]->pk
            ),
            0,
            1
        );

        return [$zipFile, $csvFile, $columns];
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Schema\Command\SchemaCommandOptions;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use D2L\DataHub\Utils\FileList;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'extracts:gen-fulldiff')]
class GenerateFullDiffExtractsCommand extends Command
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

        $this->addArgument(
            name: 'datasets',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Dataset(s) to perform action on'
        );
    }


    /**
     * @param InputInterface $input
     * @return array{0:string[]}
     */
    protected function collectInputs(InputInterface $input): array
    {
        SchemaCommandOptions::getDatasetsDir($input, $this->schemaOptions);
        ExtractCommandOptions::getDownloadsDir($input, $this->options);

        return [$this->getArgumentArray($input, 'datasets')];
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
        list($selected) = $this->collectInputs($input);

        $fullDiffs = $this->getExtractsToGen($selected);
        foreach ($fullDiffs as $fullDiff => list($previousFull, $currentFull)) {
            $this->genFullDiff($previousFull, $currentFull, $fullDiff);
        }

        return static::SUCCESS;
    }


    /**
     * @param string[] $selected
     * @return array<string,array{0:string,1:string}>
     */
    private function getExtractsToGen(array $selected): array
    {
        $downloaded = array_filter(
            array_map(
                fn ($v) => [$v, ...explode('_', $v)],
                array_keys(FileList::get($this->options->downloadsDir, $this->options->downloadsFileExt))
            ),
            fn ($v) => (count($selected) < 1 || in_array($v[1], $selected, true))
                && ($v[4] === 'Full' || $v[4] === 'FullDiff')
        );

        $datasets = [];
        foreach ($downloaded as $extract) {
            list($extractName, $datasetName, $date, $time, $bdsType) = $extract;
            if (!isset($datasets[$datasetName])) {
                $datasets[$datasetName] = [];
            }
            if (!isset($datasets[$datasetName]["{$date}_{$time}"])) {
                $datasets[$datasetName]["{$date}_{$time}"] = [];
            }
            $datasets[$datasetName]["{$date}_{$time}"][$bdsType] = $extractName;
        }

        /** @var array<string,array<string,array<string,string>>> $datasets */
        foreach ($datasets as $datasetName => $extracts) {
            ksort($extracts);

            /** @var array<string,array<string,string>> $extracts */
            foreach ($extracts as $timestamp => $bdsTypes) {
                $full = $bdsTypes['Full'] ?? null;
                $fullDiff = $bdsTypes['FullDiff'] ?? null;

                if (is_string($full)) {
                    $datasets[$datasetName][$timestamp] = [$full, is_string($fullDiff)];
                } else {
                    unset($datasets[$datasetName][$timestamp]);
                }
            }

            if (count($datasets[$datasetName]) < 2) {
                unset($datasets[$datasetName]);
            }
        }

        $fullDiffList = [];

        /** @var array<string,array<string,array{0:string,1:bool}>> $datasets */
        foreach ($datasets as $datasetName => $extracts) {
            if (count($extracts) > 1) {
                list($prev,) = array_shift($extracts);
                foreach ($extracts as $timestamp => list($curr, $hasFullDiff)) {
                    if ($hasFullDiff === false) {
                        $fullDiffList["{$datasetName}_{$timestamp}_FullDiff"] = [$prev, $curr];
                    }
                    $prev = $curr;
                }
            }
        }

        return $fullDiffList;
    }


    /**
     * @param string $previousFull
     * @param string $currentFull
     * @param string $fullDiff
     * @return void
     */
    private function genFullDiff(
        string $previousFull,
        string $currentFull,
        string $fullDiff
    ): void {
        $cmd = sprintf(
            "%s %s %s %s %s %s",
            escapeshellcmd("{$this->options->appDir}/bin/utils/gen-fulldiff-extract"),
            escapeshellarg($this->schemaOptions->datasetsDir),
            escapeshellarg($this->options->downloadsDir),
            escapeshellarg($previousFull),
            escapeshellarg($currentFull),
            escapeshellarg(sprintf(
                "%s/%s%s",
                $this->options->downloadsDir,
                $fullDiff,
                $this->options->downloadsFileExt
            ))
        );
        $output = [];
        $returnCode = 0;
        exec($cmd, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \RuntimeException("Return code: {$returnCode}");
        }

        $this->logger?->info("<Gen FullDiff Extract> " . $this->formatLogResults([
            "Extract" => $fullDiff,
            "Previous" => $previousFull,
            "Current" => $currentFull
        ]));
    }
}

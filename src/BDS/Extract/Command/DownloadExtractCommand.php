<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\Utils\FileIO;
use mjfk23\Console\Command\Command;
use mjfk23\D2LAPI\DataHub\DataHubAPI;
use mjfk23\D2LAPI\DataHub\Model\BDSExtractInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'extracts:download')]
class DownloadExtractCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     * @param DataHubAPI $dataHubAPI
     */
    public function __construct(
        private BDSExtractOptions $options,
        private DataHubAPI $dataHubAPI
    ) {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        ExtractCommandOptions::configAvailableDir($this, $this->options);
        ExtractCommandOptions::configDownloadsDir($this, $this->options);

        $this->addArgument(
            name: 'extract',
            mode: InputOption::VALUE_REQUIRED,
            description: 'Extract to download'
        );
    }


    /**
     * @param InputInterface $input
     * @return array{0:string,1:string,2:string}
     */
    protected function collectInputs(InputInterface $input): array
    {
        ExtractCommandOptions::getAvailableDir($input, $this->options);
        ExtractCommandOptions::getDownloadsDir($input, $this->options);
        list($extractName) = ExtractCommandOptions::getExtract($input);

        return [
            "{$this->options->availableDir}/{$extractName}{$this->options->availableFileExt}",
            "{$this->options->downloadsDir}/{$extractName}{$this->options->downloadsFileExt}",
            $extractName
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
            $availablePath,
            $downloadPath,
            $extractName
        ) = $this->collectInputs($input);

        $bytes = $this->dataHubAPI->downloadBDSExtract(
            BDSExtractInfo::create(
                FileIO::jsonDecode(
                    FileIO::getContents($availablePath)
                )
            ),
            $downloadPath
        );

        $this->logger?->info("<Download Extract> " . $this->formatLogResults([
            "Extract" => $extractName,
            "Size" => $bytes
        ]));

        return static::SUCCESS;
    }
}

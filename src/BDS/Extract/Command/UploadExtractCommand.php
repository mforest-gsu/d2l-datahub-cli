<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\ExtractUploader\ExtractUploader;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Extract\Model\BDSExtractProcessInfo;
use D2L\DataHub\Utils\FileIO;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'extracts:upload')]
class UploadExtractCommand extends Command
{
    /**
     * @param BDSExtractOptions $options
     * @param (callable(BDSExtractOptions $options):ExtractUploader) $uploaderFactory
     */
    public function __construct(
        private BDSExtractOptions $options,
        private mixed $uploaderFactory
    ) {
        parent::__construct(false, true);
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        ExtractCommandOptions::configProcessDir($this, $this->options);
        ExtractCommandOptions::configUploadsDir($this, $this->options);
        ExtractCommandOptions::configUploadsDatabase($this, $this->options);
        ExtractCommandOptions::configUploaderClass($this, $this->options);
        ExtractCommandOptions::configExtract($this);
    }


    /**
     * @param InputInterface $input
     * @return array{0:ExtractUploader,1:string,2:BDSExtractProcessInfo}
     */
    protected function collectInputs(InputInterface $input): array
    {
        ExtractCommandOptions::getProcessDir($input, $this->options);
        ExtractCommandOptions::getUploadsDir($input, $this->options);
        ExtractCommandOptions::getUploadsDatabase($input, $this->options);
        ExtractCommandOptions::getUploaderClass($input, $this->options);
        list($extractName) = ExtractCommandOptions::getExtract($input);

        return [
            ($this->uploaderFactory)($this->options),
            $extractName,
            BDSExtractProcessInfo::create(
                FileIO::jsonDecode(
                    FileIO::getContents(
                        sprintf(
                            "%s/%s%s",
                            $this->options->processDir,
                            $extractName,
                            $this->options->processFileExt
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
        list(
            $extractUploader,
            $extractName,
            $processInfo
        ) = $this->collectInputs($input);

        $rows = $extractUploader->uploadExtract($processInfo);

        $this->logger?->info("<Upload Extract> " . $this->formatLogResults([
            "Extract" => $extractName,
            "Class" => (new \ReflectionClass($extractUploader))->getShortName(),
            "Rows" => $rows,
        ]));

        return static::SUCCESS;
    }
}

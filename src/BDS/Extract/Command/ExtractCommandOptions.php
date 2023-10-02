<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use D2L\DataHub\BDS\Extract\ExtractProcessor\ExtractProcessor;
use D2L\DataHub\BDS\Extract\ExtractUploader\ExtractUploader;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use mjfk23\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class ExtractCommandOptions
{
    /**
     * @param Command $cmd
     * @param BDSExtractOptions $options
     * @return void
     */
    public static function configAvailableDir(
        Command $cmd,
        BDSExtractOptions $options
    ): void {
        $cmd->addOption(
            name: 'available-dir',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Available directory',
            default: $options->availableDir
        );
    }


    /**
     * @param Command $cmd
     * @param BDSExtractOptions $options
     * @return void
     */
    public static function configDownloadsDir(
        Command $cmd,
        BDSExtractOptions $options
    ): void {
        $cmd->addOption(
            name: 'downloads-dir',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Downloads directory',
            default: $options->downloadsDir
        );
    }


    /**
     * @param Command $cmd
     * @param BDSExtractOptions $options
     * @return void
     */
    public static function configProcessDir(
        Command $cmd,
        BDSExtractOptions $options
    ): void {
        $cmd->addOption(
            name: 'process-dir',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Process directory',
            default: $options->processDir
        );
    }


    /**
     * @param Command $cmd
     * @param BDSExtractOptions $options
     * @return void
     */
    public static function configUploadsDir(
        Command $cmd,
        BDSExtractOptions $options
    ): void {
        $cmd->addOption(
            name: 'uploads-dir',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Uploads directory',
            default: $options->uploadsDir
        );
    }


    /**
     * @param Command $cmd
     * @param BDSExtractOptions $options
     * @return void
     */
    public static function configProcessorClass(
        Command $cmd,
        BDSExtractOptions $options
    ): void {
        $cmd->addOption(
            name: 'processor-class',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Extract processor class',
            default: $options->processorClass
        );
    }


    /**
     * @param Command $cmd
     * @param BDSExtractOptions $options
     * @return void
     */
    public static function configUploadsDatabase(
        Command $cmd,
        BDSExtractOptions $options
    ): void {
        $cmd->addOption(
            name: 'uploads-database',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Uploads database',
            default: $options->uploadsDatabase
        );
    }


    /**
     * @param Command $cmd
     * @param BDSExtractOptions $options
     * @return void
     */
    public static function configUploaderClass(
        Command $cmd,
        BDSExtractOptions $options
    ): void {
        $cmd->addOption(
            name: 'uploader-class',
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Extract uploader class',
            default: $options->uploaderClass
        );
    }


    /**
     * @param InputInterface $input
     * @param BDSExtractOptions $options
     * @return array{0:string,1:string}
     */
    public static function getAvailableDir(
        InputInterface $input,
        BDSExtractOptions $options
    ): array {
        $availableDir = $input->getOption('available-dir') ?? $options->availableDir;
        if (is_string($availableDir) && is_dir($availableDir)) {
            $options->availableDir = $availableDir;
            return [$options->availableDir, $options->availableFileExt];
        }
        throw new \RuntimeException("Available directory not found");
    }


    /**
     * @param InputInterface $input
     * @param BDSExtractOptions $options
     * @return array{0:string,1:string}
     */
    public static function getDownloadsDir(
        InputInterface $input,
        BDSExtractOptions $options
    ): array {
        $downloadsDir = $input->getOption('downloads-dir') ?? $options->downloadsDir;
        if (is_string($downloadsDir) && is_dir($downloadsDir)) {
            $options->downloadsDir = $downloadsDir;
            return [$options->downloadsDir, $options->downloadsFileExt];
        }
        throw new \RuntimeException("Downloads directory not found");
    }


    /**
     * @param InputInterface $input
     * @param BDSExtractOptions $options
     * @return array{0:string,1:string}
     */
    public static function getProcessDir(
        InputInterface $input,
        BDSExtractOptions $options
    ): array {
        $processDir = $input->getOption('process-dir') ?? $options->processDir;
        if (is_string($processDir) && is_dir($processDir)) {
            $options->processDir = $processDir;
            return [$options->processDir, $options->processFileExt];
        }
        throw new \RuntimeException("Process directory not found");
    }


    /**
     * @param InputInterface $input
     * @param BDSExtractOptions $options
     * @return array{0:string,1:string}
     */
    public static function getUploadsDir(
        InputInterface $input,
        BDSExtractOptions $options
    ): array {
        $uploadsDir = $input->getOption('uploads-dir') ?? $options->uploadsDir;
        if (is_string($uploadsDir) && is_dir($uploadsDir)) {
            $options->uploadsDir = $uploadsDir;
            return [$options->uploadsDir, $options->uploadsFileExt];
        }
        throw new \RuntimeException("Uploads directory not found");
    }


    /**
     * @param InputInterface $input
     * @param BDSExtractOptions $options
     * @return string
     */
    public static function getProcessorClass(
        InputInterface $input,
        BDSExtractOptions $options
    ): string {
        $processorClass = $input->getOption('processor-class') ?? $options->processorClass;
        if (is_string($processorClass)) {
            if (!class_exists($processorClass)) {
                throw new \ReflectionException("Class not found: {$processorClass}");
            }
            $classDef = new \ReflectionClass($processorClass);
            if (!$classDef->isInstantiable() || !$classDef->isSubclassOf(ExtractProcessor::class)) {
                throw new \ReflectionException("Invalid class type: {$processorClass}");
            }
            /** @var \ReflectionClass<ExtractProcessor> $classDef */
            $options->processorClass = $classDef->getName();
            return $options->processorClass;
        } else {
            throw new \RuntimeException("Extract processor class not set");
        }
    }


    /**
     * @param InputInterface $input
     * @param BDSExtractOptions $options
     * @return string
     */
    public static function getUploadsDatabase(
        InputInterface $input,
        BDSExtractOptions $options
    ): string {
        $uploadsDatabase = $input->getOption('uploads-database') ?? $options->uploadsDatabase;
        if (is_string($uploadsDatabase)) {
            $options->uploadsDatabase = $uploadsDatabase;
            return $options->uploadsDatabase;
        }
        throw new \RuntimeException("Uploads database not set");
    }


    /**
     * @param InputInterface $input
     * @param BDSExtractOptions $options
     * @return string
     */
    public static function getUploaderClass(
        InputInterface $input,
        BDSExtractOptions $options
    ): string {
        $uploaderClass = $input->getOption('uploader-class') ?? $options->uploaderClass;
        if (is_string($uploaderClass)) {
            if (!class_exists($uploaderClass)) {
                throw new \ReflectionException("Class not found: {$uploaderClass}");
            }
            $classDef = new \ReflectionClass($uploaderClass);
            if (!$classDef->isInstantiable() || !$classDef->isSubclassOf(ExtractUploader::class)) {
                throw new \ReflectionException("Invalid class type: {$uploaderClass}");
            }
            /** @var \ReflectionClass<ExtractUploader> $classDef */
            $options->uploaderClass = $classDef->getName();
            return $options->uploaderClass;
        } else {
            throw new \RuntimeException("Extract uploader class not set");
        }
    }


    /**
     * @param InputInterface $input
     * @return array{0:string,1:string,2:string}
     */
    public static function getExtract(InputInterface $input): array
    {
        $extractName = $input->getArgument('extract');
        if (!is_string($extractName)) {
            throw new \RuntimeException("Extract not specified");
        }
        list($datasetName,,, $bdsType) = explode('_', $extractName);
        return [$extractName, $datasetName, $bdsType];
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\Utils;

final class FileIO
{
    /**
     * @param mixed $value
     * @param int $flags
     * @return string
     */
    public static function jsonEncode(
        mixed $value,
        int $flags = JSON_PRETTY_PRINT
    ): string {
        $json = json_encode($value, $flags | JSON_THROW_ON_ERROR);
        // if (!is_string($json)) {
        //     throw new \RuntimeException("Error converting value into JSON string");
        // }
        return $json;
    }


    /**
     * @param string $json
     * @param int $flags
     * @return mixed[]
     */
    public static function jsonDecode(
        string $json,
        int $flags = 0
    ): array {
        $value = json_decode($json, true, 512, $flags | JSON_THROW_ON_ERROR);
        if (!is_array($value)) {
            throw new \RuntimeException("Error converting JSON string into value");
        }
        return $value;
    }


    /**
     * @param string $path
     * @param string|string[] $contents
     * @return int
     */
    public static function putContents(
        string $path,
        string|array $contents
    ): int {
        $bytes = file_put_contents(
            $path,
            (is_array($contents) ? implode("\n", $contents) : $contents) . "\n"
        );
        if ($bytes === false) {
            throw new \RuntimeException("Error writing contents to file: {$path}");
        }
        return $bytes;
    }


    /**
     * @param string $path
     * @return string
     */
    public static function getContents(string $path): string
    {
        $contents = file_get_contents($path);
        if ($contents === false) {
            throw new \RuntimeException("Error reading contents from file: {$path}");
        }
        return $contents;
    }


    /**
     * @param string $path
     * @return array{0:\ZipArchive,1:resource}
     */
    public static function openZipFile(string $path): array
    {
        $zipFile = new \ZipArchive();
        if ($zipFile->open($path) !== true) {
            throw new \RuntimeException("Unable to open zip file: {$path}");
        }

        $zipFileStream = $zipFile->getStream(strval($zipFile->getNameIndex(0)));
        if (!is_resource($zipFileStream)) {
            throw new \RuntimeException("Unable to open zip file: {$path}");
        }

        // Strip byte order mark (BOM)
        fread($zipFileStream, 3);

        return [$zipFile, $zipFileStream];
    }


    /**
     * @param string $path
     * @param string $mode
     * @return resource
     */
    public static function openGzipFile(
        string $path,
        string $mode = 'w9'
    ): mixed {
        $gzipFile = gzopen($path, $mode);
        return is_resource($gzipFile)
            ? $gzipFile
            : throw new \RuntimeException("Unable to open gzip file: {$path}");
    }


    /**
     * @param string $path
     * @param string $mode
     * @return resource
     */
    public static function openFile(
        string $path,
        string $mode
    ): mixed {
        $file = fopen($path, $mode);
        return is_resource($file)
            ? $file
            : throw new \RuntimeException("Unable to open file: {$path}");
    }
}

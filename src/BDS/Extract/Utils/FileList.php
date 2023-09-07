<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Utils;

final class FileList
{
    /**
     * @param string $dir
     * @param string $ext
     * @return array<string,string>
     */
    public static function get(
        string $dir,
        string $ext
    ): array {
        $files = scandir($dir);
        return array_column(
            array_map(
                fn ($v) => [
                    "{$dir}/{$v}",
                    strlen($ext) > 0 ? substr($v, 0, -1 * strlen($ext)) : $v,
                ],
                array_filter(
                    is_array($files) ? $files : [],
                    fn ($v) => is_file("{$dir}/{$v}") && str_ends_with($v, $ext)
                )
            ),
            0,
            1
        );
    }
}

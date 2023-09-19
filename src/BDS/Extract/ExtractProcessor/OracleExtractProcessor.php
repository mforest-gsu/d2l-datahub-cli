<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\ExtractProcessor;

use D2L\DataHub\BDS\Extract\ExtractProcessor;
use D2L\DataHub\BDS\Extract\Model\BDSExtractOptions;
use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaNameMap;

class OracleExtractProcessor extends ExtractProcessor
{
    public static string $processFileExtension = '.dat.gz';

    /** @var array<string,string> */
    private const SPECIAL_CHARS = [
        "\xC2\xAB" => "<<",
        "\xC2\xBB" => ">>",
        "\xE2\x80\x98" => "'",
        "\xE2\x80\x99" => "'",
        "\xE2\x80\x9A" => "'",
        "\xE2\x80\x9B" => "'",
        "\xE2\x80\x9C" => '"',
        "\xE2\x80\x9D" => '"',
        "\xE2\x80\x9E" => '"',
        "\xE2\x80\x9F" => '"',
        "\xE2\x80\xB9" => "<",
        "\xE2\x80\xBA" => ">",
        "\xE2\x80\x93" => "-",
        "\xE2\x80\x94" => "-",
        "\xE2\x80\xA6" => "...",
        "\t" => " ",
        "\r" => " ",
        "\n" => " ",
    ];

    /** @var array<string> $search */
    private array $search;

    /** @var array<string> $replacements */
    private array $replacements;


    /**
     * @param BDSExtractOptions $options
     * @param BDSSchemaNameMap $nameMap
     */
    public function __construct(
        protected BDSExtractOptions $options,
        protected BDSSchemaNameMap $nameMap
    ) {
        parent::__construct($options, $nameMap);
        $this->search = array_keys(self::SPECIAL_CHARS);
        $this->replacements = array_values(self::SPECIAL_CHARS);
    }


    /**
     * @param BDSSchema $schema
     * @param string $bdsType
     * @param string $extractName
     * @param string $extractPath
     * @return int
     */
    public function processExtract(
        BDSSchema $schema,
        string $bdsType,
        string $extractName,
        string $extractPath
    ): int {
        $ctlPath = $this->getProcessPath($extractName, '.ctl');
        $sqlPath = $this->getProcessPath($extractName, '.sql');
        $datPath = $this->getProcessPath($extractName, '.dat');
        $tableName = $this->getTableName($schema);
        $columns = [];

        $rows = $this->generateDatFile(
            $schema,
            $extractPath,
            $datPath . '.gz',
            $columns
        );

        if ($rows > 0) {
            OracleLoaderFileGenerator::generateCtlFile(
                $ctlPath,
                ($bdsType === 'Full') ? $tableName : $tableName . '_LOAD',
                $columns
            );

            OracleLoaderFileGenerator::generateSqlFile(
                $sqlPath,
                $bdsType,
                $tableName . '_LOAD',
                $tableName,
                $columns
            );
        }

        return $rows;
    }


    /**
     * @param BDSSchema $schema
     * @param string $extractPath
     * @param string $datPath
     * @param array<int,BDSSchemaColumn> $columns
     * @return int
     */
    private function generateDatFile(
        BDSSchema $schema,
        string $extractPath,
        string $datPath,
        array &$columns
    ): int {
        $error = false;
        $total = 0;

        try {
            // Open input and output files
            list($zipFile, $extractFile) = $this->openExtractFile($extractPath);
            $datFile = $this->openProcessFile($datPath);

            // Read first line in file and map column positions to dataset fields
            $columns = $this->getColumns($schema, $extractFile);
            $formatters = $this->getColumnFormatters($columns);

            // For each row in extract
            while ($row = fgetcsv(stream: $extractFile, escape: '"')) {
                foreach ($row as $i => $v) {
                    $row[$i] = ($formatters[$i])($v);
                }
                fputcsv($datFile, $row, ",", "\"", "", "\n");
                $total++;
            }
        } catch (\Throwable $t) {
            $error = true;
            throw new \RuntimeException("Error processing {$extractPath}", 0, $t);
        } finally {
            // Close extract file
            if (is_resource($extractFile ?? null)) {
                @fclose($extractFile);
            }
            if (($zipFile ?? null) instanceof \ZipArchive) {
                @$zipFile->close();
            }

            // Close process file
            if (is_resource($datFile ?? null)) {
                @gzclose($datFile);
            }

            unset($zipFile, $extractFile, $datFile);

            if ($error === true) {
                // Remove process file if there was an error
                @unlink($datPath);
            }
        }

        return $total;
    }


    /**
     * @param array<int,BDSSchemaColumn> $columns
     * @return array<int,(\Closure(string $v): string)>
     */
    private function getColumnFormatters(array $columns): array
    {
        return array_map(
            function (BDSSchemaColumn $column): \Closure {
                /** @var (\Closure(string $v): string) $out */
                $out = match ($column->dataType) {
                    'bit' => fn ($v) => ($v === '') ? ''
                        : match (strtoupper($v)) {
                            "1", "T", "TRUE" => "1",
                            default => "0"
                        },
                    'nvarchar', 'varchar' => fn ($v) => ($v === '') ? ''
                        : str_replace($this->search, $this->replacements, $v),
                    default => fn ($v) => $v,
                };

                return $out;
            },
            $columns
        );
    }
}

<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema;

use D2L\DataHub\BDS\Schema\Model\BDSSchema;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaColumn;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaNameMap;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;

class ModuleParser
{
    /**
     * @param BDSSchemaOptions $options
     * @param BDSSchemaNameMap $schemaNameMap
     */
    public function __construct(
        private BDSSchemaOptions $options,
        private BDSSchemaNameMap $schemaNameMap
    ) {
    }


    /**
     * @param string $moduleName
     * @return array<string,BDSSchema>
     */
    public function parse(string $moduleName): array
    {
        return $this->parseMainContent(
            $this->getMainContent(
                $this->getDocument($moduleName)
            )
        );
    }


    /**
     * @param string $moduleName
     * @return \DOMDocument
     */
    private function getDocument(string $moduleName): \DOMDocument
    {
        $contents = file_get_contents("{$this->options->modulesDir}/{$moduleName}.html");
        if ($contents === false) {
            throw new \RuntimeException();
        }

        $document = new \DOMDocument();
        if (!@$document->loadHTML($contents)) {
            throw new \RuntimeException();
        }

        return $document;
    }


    /**
     * @param \DOMDocument $document
     * @return \DOMNode
     */
    private function getMainContent(\DOMDocument $document): \DOMNode
    {
        $pageContent = $document->getElementById("fallbackPageContent");
        if ($pageContent === null) {
            throw new \RuntimeException();
        }

        $main = $this->findChildrenByName($pageContent, 'main')[0] ?? null;
        if ($main === null) {
            throw new \RuntimeException();
        }

        $section = $this->findChildrenByName($main, 'section')[0] ?? null;
        if ($section === null) {
            throw new \RuntimeException();
        }

        $sectionDivs = $this->findChildrenByName($section, 'div');
        if (count($sectionDivs) < 1) {
            throw new \RuntimeException();
        }

        $mainColumn = null;
        foreach ($sectionDivs as $div) {
            if ($div->attributes !== null) {
                foreach ($div->attributes as $name => $attr) {
                    if ($name !== "class" || !$attr instanceof \DOMAttr) {
                        continue;
                    }

                    if (str_contains($attr->nodeValue ?? '', "mainColumn")) {
                        $mainColumn = $div;
                        break;
                    }
                }
            }
        }
        if ($mainColumn === null) {
            throw new \RuntimeException();
        }

        $article = $this->findChildrenByName($mainColumn, 'article')[0] ?? null;
        if ($article === null) {
            throw new \RuntimeException();
        }

        return $article;
    }


    /**
     * @param \DOMNode $mainContent
     * @return array<string,BDSSchema>
     */
    private function parseMainContent(\DOMNode $mainContent): array
    {
        $datasets = [];
        $datasetIdx = -1;

        for ($idx = 0; $idx < $mainContent->childNodes->length; $idx++) {
            $item = $mainContent->childNodes->item($idx);
            if (!$item instanceof \DOMNode || $item->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            switch ($item->nodeName) {
                case 'h2':
                    $apiName = $this->cleanString($item->nodeValue);
                    try {
                        $apiName = $this->schemaNameMap->getAPIName($apiName);
                    } catch (\Throwable) {
                    }

                    $datasets[] = new BDSSchema($apiName);
                    $datasetIdx = count($datasets) - 1;
                    break;
                case 'p':
                    if ($datasetIdx >= 0) {
                        $new = $this->cleanString($item->nodeValue);
                        if ($new !== "Returned Fields") {
                            $current = $datasets[$datasetIdx]->description;
                            $datasets[$datasetIdx]->description = $this->cleanString(
                                $current . (strlen($current) > 0 ? ' ' : '') . $new
                            );
                        }
                    }
                    break;
                case 'table':
                    if ($datasetIdx >= 0 && count($datasets[$datasetIdx]->columns) < 1) {
                        $datasets[$datasetIdx]->columns = $this->parseTable($item);
                    }
                    break;
            }
        }

        return array_column(
            array_filter(
                $datasets,
                fn ($v) => strlen($v->name) > 0 && count($v->columns) > 0
            ),
            null,
            'name'
        );
    }


    /**
     * @param \DOMNode $item
     * @return BDSSchemaColumn[]
     */
    private function parseTable(\DOMNode $item): array
    {
        $body = $this->findChildrenByName($item, 'tbody')[0] ?? null;
        $rows = $this->findChildrenByName($body, 'tr');

        $fields = [];
        foreach ($rows as $row) {
            $cols = $this->findChildrenByName($row, 'td');
            $fields[] = new BDSSchemaColumn(
                name: $this->parseTableCell($cols[1] ?? null),
                description: $this->parseTableCell($cols[2] ?? null),
                dataType: $this->parseTableCell($cols[3] ?? null),
                columnSize: $this->parseTableCell($cols[4] ?? null),
                key: $this->parseTableCell($cols[5] ?? null),
                versionHistory: $this->parseTableCell($cols[0] ?? null),
            );
        }

        return array_values(
            array_filter(
                $fields,
                fn ($v) => strlen($v->dataType) > 0
            )
        );
    }


    /**
     * @param \DOMNode|null $item
     * @return string
     */
    private function parseTableCell(?\DOMNode $item): string
    {
        if ($item === null) {
            return '';
        }

        $lines = $this->findChildrenByName($item, 'p');

        if (count($lines) > 1) {
            $cellValue = '';
            foreach ($lines as $line) {
                $new = $this->cleanString($line->nodeValue);
                $cellValue = $this->cleanString($cellValue . (strlen($cellValue) > 0 ? ' ' : '') . $new);
            }
        } else {
            $cellValue = $this->cleanString($item->nodeValue);
        }

        return $cellValue;
    }


    /**
     * @param string|null $value
     * @return string
     */
    private function cleanString(?string $value): string
    {
        /** @var string $name */
        $name = preg_replace(
            '/[ ]+/',
            ' ',
            trim(
                strval($value ?? ''),
                " \t\n\r\0\x0B\xc2\xa0"
            )
        );

        return $name;
    }


    /**
     * @param ?\DOMNode $node
     * @param string $name
     * @return \DOMNode[]
     */
    private function findChildrenByName(?\DOMNode $node, string $name): array
    {
        $children = [];

        for ($idx = 0; $idx < $node?->childNodes->length; $idx++) {
            $item = $node->childNodes->item($idx);
            if ($item instanceof \DOMNode && $item->nodeType === XML_ELEMENT_NODE && $item->nodeName === $name) {
                $children[] = $item;
            }
        }

        return $children;
    }
}

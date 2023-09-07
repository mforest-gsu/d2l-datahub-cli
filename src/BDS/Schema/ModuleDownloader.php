<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Schema;

use D2L\DataHub\BDS\Schema\Model\BDSSchemaModules;
use D2L\DataHub\BDS\Schema\Model\BDSSchemaOptions;
use mjfk23\HttpClient\HttpClientMethods;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

class ModuleDownloader
{
    /**
     * @param BDSSchemaOptions $options
     * @param BDSSchemaModules $modules
     * @param ClientInterface $httpClient
     * @param ServerRequestFactoryInterface $requestFactory
     */
    public function __construct(
        private BDSSchemaOptions $options,
        private BDSSchemaModules $modules,
        private ClientInterface $httpClient,
        private ServerRequestFactoryInterface $requestFactory
    ) {
    }


    /**
     * @param string $moduleName
     * @return int
     */
    public function download(string $moduleName): int
    {
        return $this->saveModule(
            $moduleName,
            $this->fetchModule($moduleName)
        );
    }


    /**
     * @param string $moduleName
     * @return ResponseInterface
     */
    private function fetchModule(string $moduleName): ResponseInterface
    {
        $moduleURL = $this->modules->getModuleURL($moduleName);
        if ($moduleURL === null) {
            throw new \RuntimeException();
        }

        $response = $this->httpClient->sendRequest(
            $this->requestFactory->createServerRequest(
                'GET',
                $moduleURL
            )
        );

        if ($response->getStatusCode() < 200 || $response->getStatusCode() > 299) {
            throw new \RuntimeException(
                "Error fetching contents: code " . $response->getStatusCode() . ", module {$moduleName}"
            );
        }

        return $response;
    }


    /**
     * @param string $moduleName
     * @param ResponseInterface $response
     * @return int
     */
    private function saveModule(
        string $moduleName,
        ResponseInterface $response
    ): int {
        try {
            $totalBytes = HttpClientMethods::writeResponseToFile(
                $response,
                "{$this->options->modulesDir}/{$moduleName}.html"
            );
        } catch (\Throwable $t) {
            throw new \RuntimeException("Error writing contents to disk, module {$moduleName}", 0, $t);
        }

        if ($totalBytes < 1) {
            throw new \RuntimeException("Empty response body, module '{$moduleName}'");
        }

        return $totalBytes;
    }
}

<?php

declare(strict_types=1);

namespace EthereumPHP\Client;

use EthereumPHP\Exception\JsonRpcException;
use EthereumPHP\Utils\JsonRpcRequest;
use EthereumPHP\Utils\UuidGenerator;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class JsonRpcClient
{
    private const int DEFAULT_TIMEOUT = 10;

    private HttpClientInterface $httpClient;

    public function __construct(string $url)
    {
        $this->httpClient = HttpClient::createForBaseUri($url);
    }

    public function request(string $method, array $params = [], int $timeout = self::DEFAULT_TIMEOUT): bool|string|int|float|array
    {
        $requestPayload = new JsonRpcRequest(UuidGenerator::v4(), $method, $params);

        try {
            $response = $this->httpClient->request('POST', '/', [
                'json' => $requestPayload->toArray(),
                'timeout' => $timeout,
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                throw new JsonRpcException("HTTP error: {$statusCode}");
            }

            $content = $response->toArray(false);

            if (isset($content['error'])) {
                $error = $content['error'];
                throw new JsonRpcException("RPC Error {$error['code']}: {$error['message']}");
            }

            return $content['result'];
        } catch (\Throwable $e) {
            throw new JsonRpcException("Request failed: " . $e->getMessage(), 0, $e);
        }
    }
}

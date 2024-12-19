<?php

declare(strict_types=1);

namespace EthereumPHP\Tests\Utils;

use EthereumPHP\Utils\JsonRpcRequest;
use EthereumPHP\Utils\UuidGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \EthereumPHP\Utils\JsonRpcRequest
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class JsonRpcRequestTest extends TestCase
{
    /**
     * @covers ::toArray
     */
    public function testCreateRequest(): void
    {
        $uuid = UuidGenerator::v4();

        $request = new JsonRpcRequest($uuid, 'testMethod', ['param1', 'param2']);

        $this->assertSame([
            'jsonrpc' => JsonRpcRequest::JSON_RPC_VERSION,
            'method' => 'testMethod',
            'params' => ['param1', 'param2'],
            'id' => $uuid,
        ], $request->toArray());
    }
}

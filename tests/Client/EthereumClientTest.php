<?php

namespace Client;

use EthereumPHP\Client\EthereumClient;
use EthereumPHP\Utils\EthereumConverter;
use EthereumPHP\Utils\NumberFormatter;
use PHPUnit\Framework\TestCase;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 *
 * @coversDefaultClass \EthereumPHP\Client\EthereumClient
 * @covers \EthereumPHP\Client\JsonRpcClient::request
 *
 * @group EthereumClient
 */
class EthereumClientTest extends TestCase
{
    private EthereumClient $client;

    protected function setUp(): void
    {
        $this->client = new EthereumClient('http://localhost:7545');
    }

    /**
     * @covers ::getClientVersion
     */
    public function testGetClientVersion(): void
    {
        $clientVersion = $this->client->getClientVersion();

        $this->assertNotEmpty($clientVersion);
    }

    /**
     * @covers ::getSha3
     */
    public function testGetSha3(): void
    {
        $string = '0x48656c6c6f2c20776f726c6421'; // Hello, world!
        $expectedSha3 = '0xb6e16d27ac5ab427a7f68900ac5559ce272dc6c37c82b3e052246c82244c50e4';

        $actualSha3 = $this->client->getSha3($string);

        $this->assertSame($expectedSha3, $actualSha3);
    }

    /**
     * @covers ::getNetworkVersion
     */
    public function testGetNetworkVersion(): void
    {
        $networkVersion = $this->client->getNetworkVersion();

        $this->assertNotEmpty($networkVersion);
    }

    /**
     * @covers ::getIsListening
     */
    public function testIsListening(): void
    {
        $isListening = $this->client->getIsListening();

        $this->assertTrue($isListening);
    }

    /**
     * @covers ::getPeerCount
     */
    public function testGetPeerCount(): void
    {
        $peerCount = $this->client->getPeerCount();

        $this->assertSame(0, $peerCount);
    }

    /**
     * @covers ::getProtocolVersion
     */
    public function testGetProtocolVersion(): void
    {
        $protocolVersion = $this->client->getProtocolVersion();

        $this->assertNotEmpty($protocolVersion);
    }

    /**
     * @covers ::getIsSyncing
     */
    public function testGetIsSyncing(): void
    {
        $isSyncing = $this->client->getIsSyncing();

        $this->assertFalse($isSyncing);
    }

    /**
     * @covers ::getChainId
     */
    public function testGetChainId(): void
    {
        $chainId = $this->client->getChainId();

        $this->assertNotEmpty($chainId);
    }

    /**
     * @covers ::getIsMining
     */
    public function testGetIsMining(): void
    {
        $isMining = $this->client->getIsMining();

        // Ethereum nodes cannot mine since The Merge
        $this->assertTrue($isMining);
    }

    /**
     * @covers ::getHashRate
     */
    public function testGetHashRate(): void
    {
        $hashRate = $this->client->getHashRate();

        $this->assertNotEmpty($hashRate);
    }

    /**
     * @covers ::getGasPrice
     */
    public function testGetGasPrice(): void
    {
        $gasPrice = $this->client->getGasPrice();

        $this->assertTrue($gasPrice > 0);
    }

    /**
     * @covers ::getAccounts
     */
    public function testGetAccounts(): void
    {
        $accounts = $this->client->getAccounts();

        $this->assertNotEmpty($accounts);

        foreach ($accounts as $account) {
            $this->assertNotEmpty($account, 'Account address should not be empty.');
        }
    }

    /**
     * @covers ::getCurrentBlockNumber
     */
    public function testGetCurrentBlockNumber(): void
    {
        $this->expectNotToPerformAssertions();

        $this->client->getCurrentBlockNumber();
    }

    /**
     * @covers ::getCurrentBlock (deprecated)
     */
    public function testGetCurrentBlock(): void
    {
        // getCurrentBlock() is deprecated. We still test it for coverage.
        $blockNumber = $this->client->getCurrentBlock();
        $this->assertGreaterThanOrEqual(0, $blockNumber);
    }

    /**
     * @covers ::getBalance
     */
    public function testGetBalance(): void
    {
        $balance = $this->client->getBalance($this->getFirstAddress());
        // getBalance() returns a string in Wei.
        $this->assertMatchesRegularExpression('/^\d+$/', $balance);
    }

    /**
     * @covers ::getTransactionCount
     */
    public function testGetTransactionCount(): void
    {
        $txCount = $this->client->getTransactionCount($this->getFirstAddress());

        $this->assertGreaterThanOrEqual(0, $txCount);
    }

    /**
     * @covers ::getTransactionCountByHash
     */
    public function testGetTransactionCountByHash(): void
    {
        // For a real test, you'd need a valid block hash with known tx count
        // We'll just try with the latest block for demonstration.
        $latestBlockHash = $this->client->getLastBlock()->hash;
        $this->assertNotNull($latestBlockHash);

        $countByHash = $this->client->getTransactionCountByHash($latestBlockHash);

        $this->assertGreaterThanOrEqual(0, $countByHash);
    }

    /**
     * @covers ::getTransactionCountByNumber
     */
    public function testGetTransactionCountByNumber(): void
    {
        $latestBlockNumber = $this->client->getCurrentBlockNumber();
        $countByNumber = $this->client->getTransactionCountByNumber($latestBlockNumber);

        $this->assertGreaterThanOrEqual(0, $countByNumber);
    }

    /**
     * @covers ::getUncleCountByBlockHash
     */
    public function testGetUncleCountByBlockHash(): void
    {
        $latestBlock = $this->client->getLastBlock(false);
        $uncleCount = $this->client->getUncleCountByBlockHash($latestBlock->hash);
        $this->assertIsInt($uncleCount);
        $this->assertGreaterThanOrEqual(0, $uncleCount);
    }

    /**
     * @covers ::getUncleCountByBlockNumber
     */
    public function testGetUncleCountByBlockNumber(): void
    {
        $latestBlockNumber = $this->client->getCurrentBlockNumber();
        $uncleCount = $this->client->getUncleCountByBlockNumber($latestBlockNumber);
        $this->assertIsInt($uncleCount);
        $this->assertGreaterThanOrEqual(0, $uncleCount);
    }

    /**
     * @covers ::getCode
     */
    public function testGetCode(): void
    {
        $code = $this->client->getCode($this->getFirstAddress());
        // If it's not a contract, Ganache often returns '0x'.
        $this->assertIsString($code);
    }

    /**
     * @covers ::sign
     */
    public function testSign(): void
    {
        // For local Ganache, you must ensure the account is unlocked.
        // The method also won't work if your client/node doesn't allow it.
        // This is an example. Might fail if not unlocked or not supported.
        $this->markTestSkipped('Requires an unlocked account in Ganache or Geth with personal unlocked.');

        /*
                $signature = $this->client->sign($this->getFirstAddress(), 'Hello, Ethereum!');
                $this->assertIsString($signature);
                $this->assertNotEmpty($signature);
        */
    }

    /**
     * @covers ::signTransaction
     */
    public function testSignTransaction(): void
    {
        $this->markTestSkipped('Requires an unlocked account, typically not supported in many configs.');

        /*
                $tx = [
                    'from' => $this->getFirstAddress(),
                    'to' => $this->getFirstAddress(), // Self-send
                    'value' => 1_000_000_000_000_000, // 0.001 ETH (in Wei)
                    'data' => '0x0',
                ];

                $signedTx = $this->client->signTransaction($tx);
                $this->assertIsArray($signedTx);
                $this->assertArrayHasKey('raw', $signedTx);
                $this->assertArrayHasKey('tx', $signedTx);
        */
    }

    /**
     * @covers ::sendTransaction
     */
    public function testSendTransaction(): void
    {
        $this->markTestSkipped('Requires an unlocked account, often disabled in production.');

        /*
                $tx = [
                    'from' => $this->getFirstAddress(),
                    'to' => $this->getFirstAddress(),
                    'value' => 1_000_000_000_000_000, // 0.001 ETH
                    'gas' => 21000,
                ];

                $txHash = $this->client->sendTransaction($tx);
                $this->assertNotEmpty($txHash);
        */
    }

    /**
     * @covers ::sendRawTransaction
     */
    public function testSendRawTransaction(): void
    {
        $this->markTestSkipped('Requires a locally signed transaction; not trivial to test in isolation.');

        /*
                // Normally you'd sign a transaction offline or with eth_signTransaction,
                // then feed the signed data here.
                $rawTx = '0xf86c...'; // placeholder
                $txHash = $this->client->sendRawTransaction($rawTx);
                $this->assertNotEmpty($txHash);
        */
    }

    /**
     * @covers ::call
     */
    public function testCall(): void
    {
        // Usually used to call a contract method (constant function).
        // For a non-contract address, Ganache might just return '0x'.
        $this->client->call([
            'from' => $this->getFirstAddress(),
            'to'   => $this->getFirstAddress(),
            'input' => '0x',
        ]);
        $this->expectNotToPerformAssertions();
    }

    /**
     * @covers ::estimateGas
     */
    public function testEstimateGas(): void
    {
        // Estimate gas for a simple transaction from first account to itself.
        $gasEstimate = $this->client->estimateGas([
            'from' => $this->getFirstAddress(),
            'to'   => $this->getFirstAddress(),
            'value' => NumberFormatter::numericToHex(EthereumConverter::etherToWei(0.001)), // 0.001 ETH
        ]);

        $this->assertGreaterThan(0, $gasEstimate);
    }

    /**
     * @covers ::getBlockByHash
     */
    public function testGetBlockByHash(): void
    {
        $latestBlock = $this->client->getLastBlock();
        $this->assertNotNull($latestBlock->hash);

        $block = $this->client->getBlockByHash($latestBlock->hash);

        $this->assertSame($latestBlock->hash, $block->hash);
    }

    /**
     * @covers ::getBlockByNumber
     */
    public function testGetBlockByNumber(): void
    {
        $latestBlockNumber = $this->client->getCurrentBlockNumber();
        $block = $this->client->getBlockByNumber($latestBlockNumber);

        $this->assertSame($latestBlockNumber, $block->number);
    }

    /**
     * @covers ::getLastBlock
     */
    public function testGetLastBlock(): void
    {
        $block = $this->client->getLastBlock();

        $this->assertNotEmpty($block->hash);
        $this->assertNotNull($block->number);
    }

    /**
     * @covers ::getTransactionByHash
     */
    public function testGetTransactionByHash(): void
    {
        $this->markTestSkipped('Needs a known transaction hash in the local chain.');

        /*
                // Replace with a valid transaction hash
                $txHash = '0x1234abcd...';
                $tx = $this->client->getTransactionByHash($txHash);
                $this->assertSame($txHash, $tx->hash);
        */
    }

    /**
     * @covers ::getTransactionByBlockHashAndIndex
     */
    public function testGetTransactionByBlockHashAndIndex(): void
    {
        $this->markTestSkipped('Needs a known block with transactions.');

        /*
                $block = $this->client->getLastBlock(true);
                // if the block has at least one tx
                if (!empty($block->transactions)) {
                    $tx = $this->client->getTransactionByBlockHashAndIndex(
                        $block->hash,
                        0
                    );
                    $this->assertSame($block->transactions[0]->hash, $tx->hash);
                } else {
                    $this->assertTrue(true, 'No transactions to test.');
                }
        */
    }

    /**
     * @covers ::getTransactionByBlockNumberAndIndex
     */
    public function testGetTransactionByBlockNumberAndIndex(): void
    {
        $this->markTestSkipped('Needs a known block with transactions.');

        /*
                $block = $this->client->getLastBlock(true);
                if (!empty($block->transactions)) {
                    $tx = $this->client->getTransactionByBlockNumberAndIndex(
                        $block->number,
                        0
                    );
                    $this->assertSame($block->transactions[0]->hash, $tx->hash);
                } else {
                    $this->assertTrue(true, 'No transactions to test.');
                }
        */
    }

    /**
     * @covers ::getTransactionReceipt
     */
    public function testGetTransactionReceipt(): void
    {
        $this->markTestSkipped('Needs a known transaction hash to verify receipt.');

        /*
                $txHash = '0x1234abcd...';
                $receipt = $this->client->getTransactionReceipt($txHash);
                $this->assertSame($txHash, $receipt->transactionHash);
        */
    }

    /**
     * @covers ::getUncleByBlockHashAndIndex
     */
    public function testGetUncleByBlockHashAndIndex(): void
    {
        $this->markTestSkipped('Uncles are rare in Ganache/PoA. Need a real PoW chain block with uncles.');

        /*
                $blockHash = '0x1234...';
                $uncle = $this->client->getUncleByBlockHashAndIndex($blockHash, 0);
                $this->assertNotEmpty($uncle->hash);
        */
    }

    /**
     * @covers ::getUncleByBlockNumberAndIndex
     */
    public function testGetUncleByBlockNumberAndIndex(): void
    {
        $this->markTestSkipped('Uncles are rare in Ganache/PoA.');

        /*
                $blockNumber = 100;
                $uncle = $this->client->getUncleByBlockNumberAndIndex($blockNumber, 0);
                $this->assertNotEmpty($uncle->hash);
        */
    }

    /**
     * @covers ::createNewFilter
     */
    public function testCreateNewFilter(): void
    {
        // This filter will capture all events from the latest block onward
        $filterId = $this->client->createNewFilter([
            'fromBlock' => 'latest',
            'toBlock'   => 'latest',
        ]);

        // Clean up
        $uninstalled = $this->client->uninstallFilter($filterId);
        $this->assertTrue($uninstalled);
    }

    /**
     * @covers ::createNewBlockFilter
     */
    public function testCreateNewBlockFilter(): void
    {
        $filterId = $this->client->createNewBlockFilter();

        // Clean up
        $uninstalled = $this->client->uninstallFilter($filterId);
        $this->assertTrue($uninstalled);
    }

    /**
     * @covers ::newPendingTransactionFilter
     */
    public function testNewPendingTransactionFilter(): void
    {
        $filterId = $this->client->newPendingTransactionFilter();

        // Clean up
        $uninstalled = $this->client->uninstallFilter($filterId);
        $this->assertTrue($uninstalled);
    }

    /**
     * @covers ::uninstallFilter
     */
    public function testUninstallFilter(): void
    {
        // Create a filter and then uninstall it
        $filterId = $this->client->createNewBlockFilter();

        $uninstalled = $this->client->uninstallFilter($filterId);
        $this->assertTrue($uninstalled);
    }

    /**
     * @covers ::getFilterChanges
     */
    public function testGetFilterChanges(): void
    {
        $filterId = $this->client->createNewBlockFilter();

        // If no new blocks, changes might be empty
        $this->client->getFilterChanges($filterId);

        // Clean up
        $this->client->uninstallFilter($filterId);

        $this->expectNotToPerformAssertions();
    }

    /**
     * @covers ::getFilterLogs
     */
    public function testGetFilterLogs(): void
    {
        $filterId = $this->client->createNewFilter([
            'fromBlock' => 'earliest',
            'toBlock'   => 'latest',
        ]);

        $this->client->getFilterLogs($filterId);

        // Clean up
        $this->client->uninstallFilter($filterId);

        $this->expectNotToPerformAssertions();
    }

    /**
     * @covers ::getLogs
     */
    public function testGetLogs(): void
    {
        // This will fetch logs in the given range (entire chain here).
        // If you want a real test, specify an address or topics
        $this->client->getLogs([
            'fromBlock' => 'earliest',
            'toBlock'   => 'latest',
        ]);

        $this->expectNotToPerformAssertions();
    }

    /**
     * @covers ::rawRequest
     */
    public function testRawRequest(): void
    {
        $response = $this->client->rawRequest('web3_clientVersion');
        // rawRequest can return many types, but typically a string here
        $this->assertNotEmpty($response);
    }

    private function getFirstAddress(): string
    {
        return $this->client->getAccounts()[0];
    }
}

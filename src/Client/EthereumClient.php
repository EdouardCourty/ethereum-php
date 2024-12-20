<?php

declare(strict_types=1);

namespace EthereumPHP\Client;

use EthereumPHP\DTO\Block;
use EthereumPHP\DTO\Transaction;
use EthereumPHP\DTO\TransactionReceipt;
use EthereumPHP\Factory\BlockFactory;
use EthereumPHP\Factory\TransactionFactory;
use EthereumPHP\Factory\TransactionReceiptFactory;
use EthereumPHP\Utils\NumberFormatter;
use EthereumPHP\Utils\ValueExtractor;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
readonly class EthereumClient
{
    private JsonRpcClient $jsonRpcClient;

    public function __construct(string $url)
    {
        $this->jsonRpcClient = new JsonRpcClient($url);
    }

    public function rawRequest(string $method, array $params = []): bool|int|float|array|string
    {
        return $this->jsonRpcClient->request($method, $params);
    }

    public function getClientVersion(): string
    {
        return ValueExtractor::getString($this->jsonRpcClient->request('web3_clientVersion'));
    }

    public function getSha3(string $data): string
    {
        return ValueExtractor::getString($this->jsonRpcClient->request('web3_sha3', [$data]));
    }

    public function getNetworkVersion(): string
    {
        return ValueExtractor::getString($this->jsonRpcClient->request('net_version'));
    }

    public function getIsListening(): bool
    {
        return ValueExtractor::getBool($this->jsonRpcClient->request('net_listening'));
    }

    public function getPeerCount(): int
    {
        return ValueExtractor::getInt($this->jsonRpcClient->request('net_peerCount'));
    }

    public function getProtocolVersion(): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_protocolVersion'));
    }

    public function getIsSyncing(): array|bool
    {
        $response = $this->jsonRpcClient->request('eth_syncing');

        if (is_bool($response)) {
            return ValueExtractor::getBool($response);
        }

        return ValueExtractor::getArray($response);
    }

    public function getChainId(): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_chainId'));
    }

    /**
     * May only be used on Proof-Of-Work networks. May not be available on all networks since The Merge.
     */
    public function getIsMining(): bool
    {
        return ValueExtractor::getBool($this->jsonRpcClient->request('eth_mining'));
    }

    /**
     * May only be used on Proof-Of-Work networks.
     */
    public function getHashRate(): string
    {
        return ValueExtractor::getString($this->jsonRpcClient->request('eth_hashrate'));
    }

    public function getGasPrice(): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_gasPrice'));
    }

    public function getAccounts(): array
    {
        return ValueExtractor::getArray($this->jsonRpcClient->request('eth_accounts'));
    }

    public function getCurrentBlock(): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_blockNumber'));
    }

    /**
     * Returns the balance of the given address in WEI.
     */
    public function getBalance(string $address, string|int $blockNumber = 'latest'): string
    {
        $weiBalance = $this->jsonRpcClient->request('eth_getBalance', [$address, $blockNumber]);

        return NumberFormatter::hexToWei(ValueExtractor::getString($weiBalance));
    }

    public function getStorageAt(string $address, int $position, string|int $blockNumber = 'latest'): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_getStorageAt', [$address, $position, $blockNumber]));
    }

    /**
     * Returns the number of transactions sent from an address.
     */
    public function getTransactionCount(string $address, string|int $blockNumber = 'latest'): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_getTransactionCount', [$address, $blockNumber]));
    }

    public function getTransactionCountByHash(string $hash): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_getBlockTransactionCountByHash', [$hash]));
    }

    public function getTransactionCountByNumber(string|int $blockNumber = 'latest'): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_getBlockTransactionCountByNumber', [$blockNumber]));
    }

    public function getUncleCountByBlockHash(string $hash): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_getUncleCountByBlockHash', [$hash]));
    }

    public function getUncleCountByBlockNumber(string|int $blockNumber = 'latest'): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_getUncleCountByBlockNumber', [$blockNumber]));
    }

    public function getCode(string $address, string|int $blockNumber = 'latest'): string
    {
        return ValueExtractor::getString($this->jsonRpcClient->request('eth_getCode', [$address, $blockNumber]));
    }

    /**
     * The sign method calculates an Ethereum specific signature with:
     * sign(keccak256("\x19Ethereum Signed Message:\n" + len(message) + message))).
     *
     * The address to sign with must be unlocked.
     */
    public function sign(string $address, string $message): string
    {
        return ValueExtractor::getString($this->jsonRpcClient->request('eth_sign', [$address, $message]));
    }

    /**
     * @param array{
     *     from: string,
     *     to?: string,
     *     gas?: int,
     *     gasPrice?: int,
     *     value?: int,
     *     data: string,
     *     nonce?: int
     * } $transaction
     */
    public function signTransaction(array $transaction): array
    {
        return ValueExtractor::getArray($this->jsonRpcClient->request('eth_signTransaction', [$transaction]));
    }

    /**
     * @param array{
     *     from: string,
     *     to?: string,
     *     gas?: int,
     *     gasPrice?: int,
     *     value?: int,
     *     input: string,
     *     nonce?: int
     * } $transaction
     */
    public function sendTransaction(array $transaction): string
    {
        return ValueExtractor::getString($this->jsonRpcClient->request('eth_sendTransaction', [$transaction]));
    }

    public function sendRawTransaction(string $data): string
    {
        return ValueExtractor::getString($this->jsonRpcClient->request('eth_sendRawTransaction', [$data]));
    }

    /**
     * @param array{
     *     from: string,
     *     to: string,
     *     gas?: int,
     *     gasPrice?: int,
     *     value?: int,
     *     input?: string,
     *     nonce?: int
     * } $transaction
     */
    public function call(array $transaction, string|int $blockNumber = 'latest'): string
    {
        return ValueExtractor::getString($this->jsonRpcClient->request('eth_call', [$transaction, $blockNumber]));
    }

    /**
     * @param array{
     *     from?: string,
     *     to?: string,
     *     gas?: int,
     *     gasPrice?: int,
     *     value?: int,
     *     input?: string,
     *     nonce?: int
     * } $transaction
     */
    public function estimateGas(array $transaction, string|int $blockNumber = 'latest'): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_estimateGas', [$transaction, $blockNumber]));
    }

    public function getBlockByHash(string $blockHash, bool $withTransactions = false): Block
    {
        $response = ValueExtractor::getArray($this->jsonRpcClient->request('eth_getBlockByHash', [$blockHash, $withTransactions]));

        return BlockFactory::create($response, $withTransactions);
    }

    public function getBlockByNumber(string|int $blockNumber, bool $withTransactions = false): Block
    {
        $response = ValueExtractor::getArray($this->jsonRpcClient->request('eth_getBlockByNumber', [$blockNumber, $withTransactions]));

        return BlockFactory::create($response, $withTransactions);
    }

    public function getLastBlock(bool $withTransactions = false): Block
    {
        return $this->getBlockByNumber('latest', $withTransactions);
    }

    public function getTransactionByHash(string $hash): Transaction
    {
        $response = ValueExtractor::getArray($this->jsonRpcClient->request('eth_getTransactionByHash', [$hash]));

        return TransactionFactory::create($response);
    }

    public function getTransactionByBlockHashAndIndex(string $blockHash, int $index): Transaction
    {
        $response = ValueExtractor::getArray($this->jsonRpcClient->request('eth_getTransactionByBlockHashAndIndex', [$blockHash, $index]));

        return TransactionFactory::create($response);
    }

    public function getTransactionByBlockNumberAndIndex(string|int $blockNumber, int $index): Transaction
    {
        $response = ValueExtractor::getArray($this->jsonRpcClient->request('eth_getTransactionByBlockNumberAndIndex', [$blockNumber, $index]));

        return TransactionFactory::create($response);
    }

    public function getTransactionReceipt(string $hash): TransactionReceipt
    {
        $response = ValueExtractor::getArray($this->jsonRpcClient->request('eth_getTransactionReceipt', [$hash]));

        return TransactionReceiptFactory::create($response);
    }

    public function getUncleByBlockHashAndIndex(string $blockHash, int $index): Block
    {
        $response = ValueExtractor::getArray($this->jsonRpcClient->request('eth_getUncleByBlockHashAndIndex', [$blockHash, $index]));

        return BlockFactory::create($response,false);
    }

    public function getUncleByBlockNumberAndIndex(string|int $blockNumber, int $index): Block
    {
        $response = ValueExtractor::getArray($this->jsonRpcClient->request('eth_getUncleByBlockNumberAndIndex', [$blockNumber, $index]));

        return BlockFactory::create($response, false);
    }

    /**
     * @param array{
     *     fromBlock?: string|int,
     *     toBlock?: string|int,
     *     address?: string|string[],
     *     topics?: string[],
     * } $filter
     */
    public function createNewFilter(array $filter): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_newFilter', [$filter]));
    }

    public function createNewBlockFilter(): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_newBlockFilter'));
    }

    public function newPendingTransactionFilter(): int
    {
        return ValueExtractor::hexToInt($this->jsonRpcClient->request('eth_newPendingTransactionFilter'));
    }

    public function uninstallFilter(int $filterId): bool
    {
        return ValueExtractor::getBool($this->jsonRpcClient->request('eth_uninstallFilter', [$filterId]));
    }

    public function getFilterChanges(int $filterId): array
    {
        return ValueExtractor::getArray($this->jsonRpcClient->request('eth_getFilterChanges', [$filterId]));
    }

    public function getFilterLogs(int $filterId): array
    {
        return ValueExtractor::getArray($this->jsonRpcClient->request('eth_getFilterLogs', [$filterId]));
    }

    /**
     * @param array{
     *     fromBlock?: string|int,
     *     toBlock?: string|int,
     *     address?: string|string[],
     *     topics?: string[],
     *     blockHash?: string,
     * } $filter
     */
    public function getLogs(array $filter): array
    {
        return ValueExtractor::getArray($this->jsonRpcClient->request('eth_getLogs', [$filter]));
    }
}

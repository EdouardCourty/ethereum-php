# Ethereum PHP

[![PHP CI](https://github.com/EdouardCourty/ethereum-php/actions/workflows/php_ci.yml/badge.svg)](https://github.com/EdouardCourty/ethereum-php/actions/workflows/php_ci.yml)

Ethereum PHP allows you to interact with the Ethereum blockchain using PHP. <br/>
All you need to start is a running Ethereum node, with the JSON-RPC interface enabled. <br/>

### Installation

Install this package using composer:
```shell
composer require ecourty/ethereum-php
```

### Usage

**Connecting to a Node**
```php
<?php

use EthereumPHP\Client\EthereumClient;

$client = new EthereumClient('http://localhost:8545');
// ...
$balance = $clent->getBalance('0x1234567890123456789012345678901234567890');
// ...
$latestBlock = $client->getLastBlock();
// ...
```

**Using the `EthereumConverter` utility**

`EthereumPHP\Utils\EthereumConverter` provides a set of methods to convert between different Ethereum units (wei, gwei, ether). <br/>

```php
<?php

use EthereumPHP\Utils\EthereumConverter;

// ...
$weiAmount = 14500000789000000;
$etherAmount = EthereumConverter::weiToEther($weiAmount);
$gweiAmount = EthereumConverter::weiToGwei($weiAmount);
```

### Remarks

Precise numbers such as WEI / GWEI / ETHER amounts are represented as strings instead of `float` or `int` to avoid precision loss. <br/>
The `bcmath` extension is needed for this library to work.

### Features

EthereumPHP comes with a handful of methods to interact with the Ethereum blockchain. <br/>
Here is a list of all currently supported JSON-RPC methods:

- `net_version`
- `net_listening`
- `net_peerCount`
- `eth_protocolVersion`
- `eth_syncing`
- `eth_chainId`
- `eth_mining`
- `eth_hashrate`
- `eth_gasPrice`
- `eth_accounts`
- `eth_blockNumber`
- `eth_getBalance`
- `eth_getStorageAt`
- `eth_getTransactionCount`
- `eth_getBlockTransactionCountByHash`
- `eth_getBlockTransactionCountByNumber`
- `eth_getUncleCountByBlockHash`
- `eth_getUncleCountByBlockNumber`
- `eth_getCode`
- `eth_sign`
- `eth_signTransaction`
- `eth_sendTransaction`
- `eth_sendRawTransaction`
- `eth_call`
- `eth_estimateGas`
- `eth_getBlockByHash`
- `eth_getBlockByNumber`
- `eth_getTransactionByHash`
- `eth_getTransactionByBlockHashAndIndex`
- `eth_getTransactionByBlockNumberAndIndex`
- `eth_getTransactionReceipt`
- `eth_getUncleByBlockHashAndIndex`
- `eth_getUncleByBlockNumberAndIndex`
- `eth_newFilter`
- `eth_newBlockFilter`
- `eth_newPendingTransactionFilter`
- `eth_uninstallFilter`
- `eth_getFilterChanges`
- `eth_getFilterLogs`
- `eth_getLogs`

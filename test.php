<?php

require_once __DIR__ . '/vendor/autoload.php';

use EthereumPHP\Client\EthereumClient;

$ethereumClient = new EthereumClient('http://localhost:7545');

var_dump($ethereumClient->getBalance('0xD648CeeE0Dd7e8D42C4CA6a54AdeFeeC1af9E04b'));

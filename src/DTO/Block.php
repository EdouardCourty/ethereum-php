<?php

declare(strict_types=1);

namespace EthereumPHP\DTO;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class Block
{
    public ?int $number;
    public ?string $hash = null;
    public string $parentHash;
    public ?string $nonce = null;
    public string $sha3Uncles;
    public ?string $logsBloom = null;
    public string $transactionsRoot;
    public string $stateRoot;
    public string $receiptsRoot;
    public string $miner;
    public string $difficulty;
    public string $totalDifficulty;
    public string $extraData;
    public string $size;
    public string $gasLimit;
    public string $gasUsed;
    public \DateTimeImmutable $timestamp;
    public array $transactions = [];
    public array $uncles = [];
}

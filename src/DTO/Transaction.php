<?php

declare(strict_types=1);

namespace EthereumPHP\DTO;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 *
 * @codeCoverageIgnore
 */
class Transaction
{
    public ?string $blockHash = null;
    public ?int $blockNumber = null;
    public string $from;
    public string $gas;
    public string $gasPrice;
    public string $hash;
    public string $input;
    public string $nonce;
    public ?string $to = null;
    public ?int $transactionIndex = null;
    public string $value; // Wei
    public int $v; // ECDSA Recovery ID
    public string $r; // ECDSA Signature R
    public string $s; // ECDSA Signature S
}

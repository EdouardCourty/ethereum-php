<?php

declare(strict_types=1);

namespace EthereumPHP\DTO;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 *
 * @codeCoverageIgnore
 */
class TransactionReceipt
{
    public ?string $transactionHash = null;
    public int $transactionIndex;
    public string $blockHash;
    public int $blockNumber;
    public string $from;
    public string $to;
    public string $cumulativeGasUsed;
    public string $effectiveGasPrice;
    public string $gasUsed;
    public ?string $contractAddress = null;
    public array $logs = [];
    public string $logsBloom;
    public int $type;
    public bool $status;
}

<?php

declare(strict_types=1);

namespace EthereumPHP\Factory;

use EthereumPHP\DTO\TransactionReceipt;
use EthereumPHP\Utils\NumberFormatter;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class TransactionReceiptFactory
{
    public static function create(array $transactionReceiptData): TransactionReceipt
    {
        $transactionReceipt = new TransactionReceipt();

        $transactionReceipt->transactionHash = isset($transactionReceiptData['transactionHash']) ? (string) $transactionReceiptData['transactionHash'] : null;
        $transactionReceipt->transactionIndex = (int) hexdec($transactionReceiptData['transactionIndex']);
        $transactionReceipt->blockHash = $transactionReceiptData['blockHash'];
        $transactionReceipt->blockNumber = (int) hexdec($transactionReceiptData['blockNumber']);
        $transactionReceipt->from = $transactionReceiptData['from'];
        $transactionReceipt->to = $transactionReceiptData['to'];
        $transactionReceipt->cumulativeGasUsed = (string) hexdec($transactionReceiptData['cumulativeGasUsed']);
        $transactionReceipt->effectiveGasPrice = NumberFormatter::formatWei(hexdec($transactionReceiptData['effectiveGasPrice']));
        $transactionReceipt->gasUsed = (string) hexdec($transactionReceiptData['gasUsed']);
        $transactionReceipt->contractAddress = isset($transactionReceiptData['contractAddress']) ? (string) $transactionReceiptData['contractAddress'] : null;
        $transactionReceipt->logs = $transactionReceiptData['logs'];
        $transactionReceipt->logsBloom = $transactionReceiptData['logsBloom'];
        $transactionReceipt->type = (int) hexdec($transactionReceiptData['type']);
        $transactionReceipt->status = (bool) $transactionReceiptData['status'];

        return $transactionReceipt;
    }
}

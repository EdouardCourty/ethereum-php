<?php

declare(strict_types=1);

namespace EthereumPHP\Factory;

use EthereumPHP\DTO\TransactionReceipt;
use EthereumPHP\Utils\NumberFormatter;
use EthereumPHP\Utils\ValueExtractor;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class TransactionReceiptFactory
{
    public static function create(array $transactionReceiptData): TransactionReceipt
    {
        $transactionReceipt = new TransactionReceipt();

        $transactionReceipt->transactionHash = isset($transactionReceiptData['transactionHash'])
            ? ValueExtractor::getString($transactionReceiptData['transactionHash'])
            : null;
        $transactionReceipt->transactionIndex = ValueExtractor::hexToInt($transactionReceiptData['transactionIndex']);
        $transactionReceipt->blockHash = ValueExtractor::getString($transactionReceiptData['blockHash']);
        $transactionReceipt->blockNumber = ValueExtractor::hexToInt($transactionReceiptData['blockNumber']);
        $transactionReceipt->from = ValueExtractor::getString($transactionReceiptData['from']);
        $transactionReceipt->to = ValueExtractor::getString($transactionReceiptData['to']);
        $transactionReceipt->cumulativeGasUsed = (string) hexdec($transactionReceiptData['cumulativeGasUsed']);
        $transactionReceipt->effectiveGasPrice = NumberFormatter::formatWei(hexdec($transactionReceiptData['effectiveGasPrice']));
        $transactionReceipt->gasUsed = (string) hexdec($transactionReceiptData['gasUsed']);
        $transactionReceipt->contractAddress = isset($transactionReceiptData['contractAddress'])
            ? ValueExtractor::getString($transactionReceiptData['contractAddress'])
            : null;
        $transactionReceipt->logs = ValueExtractor::getArray($transactionReceiptData['logs']);
        $transactionReceipt->logsBloom = ValueExtractor::getString($transactionReceiptData['logsBloom']);
        $transactionReceipt->type = ValueExtractor::hexToInt($transactionReceiptData['type']);
        $transactionReceipt->status = (bool) $transactionReceiptData['status'];

        return $transactionReceipt;
    }
}

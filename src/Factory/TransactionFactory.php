<?php

declare(strict_types=1);

namespace EthereumPHP\Factory;

use EthereumPHP\DTO\Transaction;
use EthereumPHP\Utils\NumberFormatter;
use EthereumPHP\Utils\ValueExtractor;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class TransactionFactory
{
    public static function create(array $transactionData): Transaction
    {
        $transaction = new Transaction();

        $transaction->blockHash = isset($transactionData['blockHash'])
            ? ValueExtractor::getString($transactionData['blockHash'])
            : null;
        $transaction->blockNumber = isset($transactionData['blockNumber'])
            ? ValueExtractor::hexToInt($transactionData['blockNumber'])
            : null;
        $transaction->from = ValueExtractor::getString($transactionData['from']);
        $transaction->gas = (string) hexdec($transactionData['gas']);
        $transaction->gasPrice = NumberFormatter::formatWei(hexdec($transactionData['gasPrice']));
        $transaction->hash = ValueExtractor::getString($transactionData['hash']);
        $transaction->input = ValueExtractor::getString($transactionData['input']);
        $transaction->nonce = (string) hexdec($transactionData['nonce']);
        $transaction->to = isset($transactionData['to'])
            ? ValueExtractor::getString($transactionData['to'])
            : null;
        $transaction->transactionIndex = isset($transactionData['transactionIndex'])
            ? ValueExtractor::hexToInt($transactionData['transactionIndex'])
            : null;
        $transaction->value = NumberFormatter::formatWei(hexdec($transactionData['value']));
        $transaction->v = (int) hexdec($transactionData['v']);
        $transaction->r = ValueExtractor::getString($transactionData['r']);
        $transaction->s = ValueExtractor::getString($transactionData['s']);

        return $transaction;
    }
}

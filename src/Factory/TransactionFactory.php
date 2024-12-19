<?php

declare(strict_types=1);

namespace EthereumPHP\Factory;

use EthereumPHP\DTO\Transaction;
use EthereumPHP\Utils\NumberFormatter;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class TransactionFactory
{
    public static function create(array $transactionData): Transaction
    {
        $transaction = new Transaction();

        $transaction->blockHash = isset($transactionData['blockHash']) ? (string) $transactionData['blockHash'] : null;
        $transaction->blockNumber = isset($transactionData['blockNumber']) ? (int) hexdec($transactionData['blockNumber']) : null;
        $transaction->from = (string) $transactionData['from'];
        $transaction->gas = (string) hexdec($transactionData['gas']);
        $transaction->gasPrice = NumberFormatter::formatWei(hexdec($transactionData['gasPrice']));
        $transaction->hash = (string) $transactionData['hash'];
        $transaction->input = (string) $transactionData['input'];
        $transaction->nonce = (string) hexdec($transactionData['nonce']);
        $transaction->to = isset($transactionData['to']) ? (string) $transactionData['to'] : null;
        $transaction->transactionIndex = isset($transactionData['transactionIndex']) ? (int) hexdec($transactionData['transactionIndex']) : null;
        $transaction->value = NumberFormatter::formatWei(hexdec($transactionData['value']));
        $transaction->v = (int) hexdec($transactionData['v']);
        $transaction->r = (string) $transactionData['r'];
        $transaction->s = (string) $transactionData['s'];

        return $transaction;
    }
}

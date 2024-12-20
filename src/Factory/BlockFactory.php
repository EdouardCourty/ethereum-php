<?php

declare(strict_types=1);

namespace EthereumPHP\Factory;

use EthereumPHP\DTO\Block;
use EthereumPHP\DTO\Transaction;
use EthereumPHP\Utils\ValueExtractor;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class BlockFactory
{
    public static function create(array $blockData, bool $withTransactions): Block
    {
        $block = new Block();

        $block->number = isset($blockData['number'])
            ? ValueExtractor::hexToInt($blockData['number'])
            : null;
        $block->hash = isset($blockData['hash'])
            ? ValueExtractor::getString($blockData['hash'])
            : null;
        $block->parentHash = ValueExtractor::getString($blockData['parentHash']);
        $block->nonce = isset($blockData['nonce'])
            ? (string) hexdec($blockData['nonce'])
            : null;
        $block->sha3Uncles = ValueExtractor::getString($blockData['sha3Uncles']);
        $block->logsBloom = isset($blockData['logsBloom'])
            ? ValueExtractor::getString($blockData['logsBloom'])
            : null;
        $block->transactionsRoot = ValueExtractor::getString($blockData['transactionsRoot']);
        $block->stateRoot = ValueExtractor::getString($blockData['stateRoot']);
        $block->receiptsRoot = ValueExtractor::getString($blockData['receiptsRoot']);
        $block->miner = ValueExtractor::getString($blockData['miner']);
        $block->difficulty = (string) hexdec($blockData['difficulty']);
        $block->totalDifficulty = (string) hexdec($blockData['totalDifficulty']);
        $block->extraData = (string) $blockData['extraData'];
        $block->size = (string) hexdec($blockData['size']);
        $block->gasLimit = (string) hexdec($blockData['gasLimit']);
        $block->gasUsed = (string) hexdec($blockData['gasUsed']);
        $block->timestamp = (new \DateTimeImmutable())->setTimestamp(ValueExtractor::hexToInt($blockData['timestamp']));
        $block->uncles = ValueExtractor::getArray($blockData['uncles']);

        $transactions = ValueExtractor::getArray($blockData['transactions']);

        if (true === $withTransactions) {
            /** @var Transaction[] $transactions */
            $transactions = array_map(function (array $transactionData) {
                return TransactionFactory::create($transactionData);
            }, $transactions);
        }

        $block->transactions = $transactions;

        return $block;
    }
}

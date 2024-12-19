<?php

declare(strict_types=1);

namespace EthereumPHP\Factory;

use EthereumPHP\DTO\Block;

/**
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class BlockFactory
{
    public static function create(array $blockData): Block
    {
        $block = new Block();

        $block->number = isset($blockData['number']) ? (int) hexdec($blockData['number']) : null;
        $block->hash = isset($blockData['hash']) ? (string) $blockData['hash'] : null;
        $block->parentHash = $blockData['parentHash'];
        $block->nonce = isset($blockData['nonce']) ? (string) hexdec($blockData['nonce']) : null;
        $block->sha3Uncles = $blockData['sha3Uncles'];
        $block->logsBloom = isset($blockData['logsBloom']) ? (string) $blockData['logsBloom'] : null;
        $block->transactionsRoot = $blockData['transactionsRoot'];
        $block->stateRoot = $blockData['stateRoot'];
        $block->receiptsRoot = $blockData['receiptsRoot'];
        $block->miner = $blockData['miner'];
        $block->difficulty = (string) hexdec($blockData['difficulty']);
        $block->totalDifficulty = (string) hexdec($blockData['totalDifficulty']);
        $block->extraData = $blockData['extraData'];
        $block->size = (string) hexdec($blockData['size']);
        $block->gasLimit = (string) hexdec($blockData['gasLimit']);
        $block->gasUsed = (string) hexdec($blockData['gasUsed']);
        $block->timestamp = (new \DateTimeImmutable())->setTimestamp((int) hexdec($blockData['timestamp']));
        $block->transactions = $blockData['transactions'];
        $block->uncles = $blockData['uncles'];

        return $block;
    }
}

<?php

declare(strict_types=1);

namespace EthereumPHP\Tests\Factory;

use EthereumPHP\Factory\BlockFactory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \EthereumPHP\Factory\BlockFactory
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class BlockFactoryTest extends TestCase
{
    /**
     * @covers ::create
     */
    public function testItCreatesABlock(): void
    {
        $data = [
            'number' => '0x1',
            'hash' => '0x2',
            'parentHash' => '0x3',
            'mixHash' => '0x4',
            'nonce' => '0x5',
            'sha3Uncles' => '0x6',
            'logsBloom' => '0x0000000000000000000000000000000000000000',
            'transactionsRoot' => '0x8',
            'stateRoot' => '0x9',
            'receiptsRoot' => '0x10',
            'miner' => '0x0000000000000000000000000000000000000000',
            'difficulty' => '0x12',
            'totalDifficulty' => '0x13',
            'extraData' => '0x14',
            'size' => '0x15',
            'gasLimit' => '0x16',
            'gasUsed' => '0x17',
            'timestamp' => '0x67643915',
            'transactions' => [
                [
                    'blockHash' => '0x2',
                    'blockNumber' => '0x3',
                    'from' => '0x5',
                    'gas' => '0x9',
                    'gasPrice' => '0x8',
                    'hash' => '0x0703636b2bfc3b3907adc9e7687e61c6caddde95917620ab0a519be078d25061',
                    'input' => '0x11',
                    'nonce' => '0x12',
                    'to' => '0x6',
                    'transactionIndex' => '0x4',
                    'value' => '0x7',
                    'v' => '0x27',
                    'r' => '0x12',
                    's' => '0x13',
                ],
            ],
            'uncles' => [],
        ];

        $block = BlockFactory::create($data, true);

        $this->assertEquals(1, $block->number);
        $this->assertEquals('0x2', $block->hash);
        $this->assertEquals('0x3', $block->parentHash);
        $this->assertEquals('5', $block->nonce);
        $this->assertEquals('0x6', $block->sha3Uncles);
        $this->assertEquals('0x0000000000000000000000000000000000000000', $block->logsBloom);
        $this->assertEquals('0x8', $block->transactionsRoot);
        $this->assertEquals('0x9', $block->stateRoot);
        $this->assertEquals('0x10', $block->receiptsRoot);
        $this->assertEquals('0x0000000000000000000000000000000000000000', $block->miner);
        $this->assertEquals('18', $block->difficulty);
        $this->assertEquals('19', $block->totalDifficulty);
        $this->assertEquals('0x14', $block->extraData);
        $this->assertEquals('21', $block->size);
        $this->assertEquals('22', $block->gasLimit);
        $this->assertEquals('23', $block->gasUsed);
        $this->assertInstanceOf(\DateTimeImmutable::class, $block->timestamp);
        $this->assertCount(1, $block->transactions);
        $this->assertEquals([], $block->uncles);
    }
}

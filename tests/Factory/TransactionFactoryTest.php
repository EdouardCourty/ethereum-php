<?php

declare(strict_types=1);

namespace EthereumPHP\Tests\Factory;

use EthereumPHP\Factory\TransactionFactory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \EthereumPHP\Factory\TransactionFactory
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class TransactionFactoryTest extends TestCase
{
    /**
     * @covers ::create
     */
    public function testItCreatesATransaction(): void
    {
        $data = [
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
        ];

        $transaction = TransactionFactory::create($data);

        $this->assertEquals('0x2', $transaction->blockHash);
        $this->assertEquals(3, $transaction->blockNumber);
        $this->assertEquals('0x5', $transaction->from);
        $this->assertEquals(9, $transaction->gas);
        $this->assertEquals(8, $transaction->gasPrice);
        $this->assertEquals('0x0703636b2bfc3b3907adc9e7687e61c6caddde95917620ab0a519be078d25061', $transaction->hash);
        $this->assertEquals('0x11', $transaction->input);
        $this->assertEquals(18, $transaction->nonce);
        $this->assertEquals('0x6', $transaction->to);
        $this->assertEquals(4, $transaction->transactionIndex);
        $this->assertEquals(7, $transaction->value);
        $this->assertEquals(39, $transaction->v);
        $this->assertEquals('0x12', $transaction->r);
        $this->assertEquals('0x13', $transaction->s);
    }
}

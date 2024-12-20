<?php

declare(strict_types=1);

namespace EthereumPHP\Tests\Factory;

use EthereumPHP\DTO\TransactionReceipt;
use EthereumPHP\Factory\TransactionReceiptFactory;
use EthereumPHP\Utils\NumberFormatter;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \EthereumPHP\Factory\TransactionReceiptFactory
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class TransactionReceiptFactoryTest extends TestCase
{
    /**
     * @covers ::create
     */
    public function testCreateTransactionReceipt(): void
    {
        $transactionReceiptData = [
            'transactionHash' => '0x123abc',
            'transactionIndex' => '0x01',
            'blockHash' => '0xblockhash',
            'blockNumber' => '0x10', // hex for decimal 16
            'from' => '0xfromAddress',
            'to' => '0xtoAddress',
            'cumulativeGasUsed' => '0x5208', // hex for decimal 21000
            'effectiveGasPrice' => '0xde0b6b3a7640000', // hex for 1000000000000000000 Wei = 1 Ether
            'gasUsed' => '0x5208', // hex for 21000
            'contractAddress' => null,
            'logs' => [],
            'logsBloom' => '0xlogsBloomData',
            'type' => '0x0',
            'status' => true,
        ];

        $expectedEffectiveGasPrice = NumberFormatter::formatWei(hexdec('0xde0b6b3a7640000'));

        $transactionReceipt = TransactionReceiptFactory::create($transactionReceiptData);

        $this->assertInstanceOf(TransactionReceipt::class, $transactionReceipt);
        $this->assertSame('0x123abc', $transactionReceipt->transactionHash);
        $this->assertSame(1, $transactionReceipt->transactionIndex); // hexdec('0x01') = 1
        $this->assertSame('0xblockhash', $transactionReceipt->blockHash);
        $this->assertSame(16, $transactionReceipt->blockNumber); // hexdec('0x10') = 16
        $this->assertSame('0xfromAddress', $transactionReceipt->from);
        $this->assertSame('0xtoAddress', $transactionReceipt->to);
        $this->assertSame('21000', $transactionReceipt->cumulativeGasUsed); // hexdec('0x5208') = 21000
        $this->assertSame($expectedEffectiveGasPrice, $transactionReceipt->effectiveGasPrice);
        $this->assertSame('21000', $transactionReceipt->gasUsed); // hexdec('0x5208') = 21000
        $this->assertNull($transactionReceipt->contractAddress);
        $this->assertSame([], $transactionReceipt->logs);
        $this->assertSame('0xlogsBloomData', $transactionReceipt->logsBloom);
        $this->assertSame(0, $transactionReceipt->type); // hexdec('0x0') = 0
        $this->assertTrue($transactionReceipt->status);
    }
}

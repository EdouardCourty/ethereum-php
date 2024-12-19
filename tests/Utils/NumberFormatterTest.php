<?php

declare(strict_types=1);

namespace EthereumPHP\Tests\Utils;

use EthereumPHP\Utils\NumberFormatter;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \EthereumPHP\Utils\NumberFormatter
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class NumberFormatterTest extends TestCase
{
    /**
     * @covers ::formatWei
     */
    public function testWeiFormat(): void
    {
        $floatNumber = 1.0E+20;
        $formattedNumber = NumberFormatter::formatWei($floatNumber);

        $this->assertEquals('100000000000000000000', $formattedNumber);
    }
}

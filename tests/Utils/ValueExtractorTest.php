<?php

declare(strict_types=1);

namespace EthereumPHP\Tests\Utils;

use EthereumPHP\Utils\ValueExtractor;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \EthereumPHP\Utils\ValueExtractor
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class ValueExtractorTest extends TestCase
{
    /**
     * @covers ::getString
     */
    public function testGetStringWithValidString(): void
    {
        $result = ValueExtractor::getString('hello');
        $this->assertSame('hello', $result);
    }

    /**
     * @covers ::getString
     */
    public function testGetStringWithInvalidValues(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ValueExtractor::getString(123);
    }

    /**
     * @covers ::getInt
     */
    public function testGetIntWithValidInt(): void
    {
        $result = ValueExtractor::getInt(42);
        $this->assertSame(42, $result);
    }

    /**
     * @covers ::getInt
     */
    public function testGetIntWithStringContainingDigits(): void
    {
        $result = ValueExtractor::getInt('123');
        $this->assertSame(123, $result);
    }

    /**
     * @covers ::getInt
     */
    public function testGetIntWithInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ValueExtractor::getInt('abc');
    }

    /**
     * @covers ::getBool
     */
    public function testGetBoolWithValidBool(): void
    {
        $this->assertTrue(ValueExtractor::getBool(true));
        $this->assertFalse(ValueExtractor::getBool(false));
    }

    /**
     * @covers ::getBool
     */
    public function testGetBoolWithInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ValueExtractor::getBool('not a bool');
    }

    /**
     * @covers ::getArray
     */
    public function testGetArrayWithValidArray(): void
    {
        $input = ['foo' => 'bar'];
        $result = ValueExtractor::getArray($input);
        $this->assertSame($input, $result);
    }

    /**
     * @covers ::getArray
     */
    public function testGetArrayWithInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ValueExtractor::getArray('not an array');
    }

    /**
     * @covers ::hexToInt
     */
    public function testHexToIntWithValidHex(): void
    {
        $this->assertSame(255, ValueExtractor::hexToInt('0xFF'));
        $this->assertSame(255, ValueExtractor::hexToInt('FF'));
        $this->assertSame(0, ValueExtractor::hexToInt('0x0'));
        $this->assertSame(4095, ValueExtractor::hexToInt('FFF'));
    }

    /**
     * @covers ::hexToInt
     */
    public function testHexToIntWithInvalidHex(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ValueExtractor::hexToInt('0xGHI'); // Not a valid hex
    }

    /**
     * @covers ::getNumericString
     */
    public function testGetNumericStringWithValidNumericValues(): void
    {
        $this->assertSame('123', ValueExtractor::getNumericString(123));
        $this->assertSame('123.45', ValueExtractor::getNumericString(123.45));
        $this->assertSame('678', ValueExtractor::getNumericString('678'));
    }

    /**
     * @covers ::getNumericString
     */
    public function testGetNumericStringWithInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ValueExtractor::getNumericString('not_numeric');
    }
}

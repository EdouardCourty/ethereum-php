<?php

declare(strict_types=1);

namespace EthereumPHP\Tests\Utils;

use EthereumPHP\Utils\EthereumConverter;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \EthereumPHP\Utils\EthereumConverter
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class EthereumConverterTest extends TestCase
{
    /**
     * @covers ::weiToGwei
     */
    #[DataProvider('weiToGweiProvider')]
    public function testWeiToGwei(string $wei, string $expectedGwei): void
    {
        $gwei = EthereumConverter::weiToGwei($wei);
        $this->assertEquals($expectedGwei, $gwei, "Wei to Gwei conversion failed.");
    }

    /**
     * @covers ::gweiToWei
     */
    #[DataProvider('gweiToWeiProvider')]
    public function testGweiToWei(string $gwei, string $expectedWei): void
    {
        $wei = EthereumConverter::gweiToWei($gwei);
        $this->assertEquals($expectedWei, $wei, "Gwei to Wei conversion failed.");
    }

    /**
     * @covers ::weiToEther
     */
    #[DataProvider('weiToEtherProvider')]
    public function testWeiToEther(string $wei, string $expectedEther): void
    {
        $ether = EthereumConverter::weiToEther($wei);
        $this->assertEquals($expectedEther, $ether, "Wei to Ether conversion failed.");
    }

    /**
     * @covers ::etherToWei
     */
    #[DataProvider('etherToWeiProvider')]
    public function testEtherToWei(string $ether, string $expectedWei): void
    {
        $wei = EthereumConverter::etherToWei($ether);
        $this->assertEquals($expectedWei, $wei, "Ether to Wei conversion failed.");
    }

    /**
     * @covers ::gweiToEther
     */
    #[DataProvider('gweiToEtherProvider')]
    public function testGweiToEther(string $gwei, string $expectedEther): void
    {
        $ether = EthereumConverter::gweiToEther($gwei);
        $this->assertEquals($expectedEther, $ether, "Gwei to Ether conversion failed.");
    }

    /**
     * @covers ::etherToGwei
     */
    #[DataProvider('etherToGweiProvider')]
    public function testEtherToGwei(string $ether, string $expectedGwei): void
    {
        $gwei = EthereumConverter::etherToGwei($ether);
        $this->assertEquals($expectedGwei, $gwei, "Ether to Gwei conversion failed.");
    }

    /**
     * @covers ::validateNumeric
     */
    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $method, string $input): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches("/Invalid numeric value/");

        switch ($method) {
            case 'weiToGwei':
                EthereumConverter::weiToGwei($input);
                break;
            case 'gweiToWei':
                EthereumConverter::gweiToWei($input);
                break;
            case 'weiToEther':
                EthereumConverter::weiToEther($input);
                break;
            case 'etherToWei':
                EthereumConverter::etherToWei($input);
                break;
            case 'gweiToEther':
                EthereumConverter::gweiToEther($input);
                break;
            case 'etherToGwei':
                EthereumConverter::etherToGwei($input);
                break;
            default:
                throw new \Exception("Unknown method {$method}");
        }
    }

    // Data Providers

    public static function weiToGweiProvider(): array
    {
        return [
            ['1000000000', '1.000000000'], // 1 Gwei
            ['5000000000', '5.000000000'], // 5 Gwei
            ['1234567890123456789', '1234567890.123456789'], // Large number
            ['0', '0.000000000'], // Zero
        ];
    }

    public static function gweiToWeiProvider(): array
    {
        return [
            ['1', '1000000000'],
            ['5', '5000000000'],
            ['1234567890.123456789', '1234567890123456789'],
            ['0', '0'],
        ];
    }

    public static function weiToEtherProvider(): array
    {
        return [
            ['1000000000000000000', '1.000000000000000000'], // 1 Ether
            ['5000000000000000000', '5.000000000000000000'], // 5 Ether
            ['1234567890123456789', '1.234567890123456789'], // Large number
            ['0', '0.000000000000000000'], // Zero
        ];
    }

    public static function etherToWeiProvider(): array
    {
        return [
            ['1', '1000000000000000000'],
            ['5', '5000000000000000000'],
            ['1.234567890123456789', '1234567890123456789'],
            ['0', '0'],
        ];
    }

    public static function gweiToEtherProvider(): array
    {
        return [
            ['1000000000', '1.000000000000000000'], // 1 Gwei = 0.000000001 Ether
            ['5000000000', '5.000000000000000000'], // 5 Gwei = 0.000000005 Ether
            ['1234567890.123456789', '1.234567890123456789'],
            ['0', '0.000000000000000000'],
        ];
    }

    public static function etherToGweiProvider(): array
    {
        return [
            ['1', '1000000000.000000000'], // 1 Ether = 1,000,000,000 Gwei
            ['5', '5000000000.000000000'], // 5 Ether = 5,000,000,000 Gwei
            ['1.234567890123456789', '1234567890.123456789'],
            ['0', '0.000000000'],
        ];
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['weiToGwei', 'not-a-number'],
            ['gweiToWei', '123abc'],
            ['weiToEther', ''],
            ['etherToWei', ' '],
            ['gweiToEther', 'NaN'],
            ['etherToGwei', '@#$%'],
        ];
    }
}

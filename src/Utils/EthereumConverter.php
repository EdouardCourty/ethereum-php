<?php

declare(strict_types=1);

namespace EthereumPHP\Utils;

/**
 * Converts Ethereum units.
 *
 * @note This class only accepts strings as input to avoid floating point precision issues. All calculations are done using BCMath.
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class EthereumConverter
{
    /**
     * Number of decimal places to use in BCMath operations.
     */
    private const int SCALE = 18;

    /**
     * Converts Wei to Gwei.
     *
     * @param numeric-string $wei
     *
     * @return numeric-string
     */
    public static function weiToGwei(string $wei): string
    {
        self::validateNumeric($wei, 'Wei');
        return self::div($wei, '1000000000', 9); // 1 Gwei = 10^9 Wei
    }

    /**
     * Converts Gwei to Wei.
     *
     * @param numeric-string $gwei
     *
     * @return numeric-string
     */
    public static function gweiToWei(string $gwei): string
    {
        self::validateNumeric($gwei, 'Gwei');
        return self::mul($gwei, '1000000000', 0); // 1 Gwei = 10^9 Wei
    }

    /**
     * Converts Wei to Ether.
     *
     * @param numeric-string $wei
     *
     * @return numeric-string
     */
    public static function weiToEther(string $wei): string
    {
        self::validateNumeric($wei, 'Wei');
        return self::div($wei, '1000000000000000000', 18); // 1 Ether = 10^18 Wei
    }

    /**
     * Converts Ether to Wei.
     *
     * @param numeric-string $ether
     *
     * @return numeric-string
     */
    public static function etherToWei(string $ether): string
    {
        self::validateNumeric($ether, 'Ether');
        return self::mul($ether, '1000000000000000000', 0); // 1 Ether = 10^18 Wei
    }

    /**
     * Converts Gwei to Ether.
     *
     * @param numeric-string $gwei
     *
     * @return numeric-string
     */
    public static function gweiToEther(string $gwei): string
    {
        self::validateNumeric($gwei, 'Gwei');
        // First convert Gwei to Wei, then Wei to Ether
        $wei = self::gweiToWei($gwei);
        return self::weiToEther($wei);
    }

    /**
     * Converts Ether to Gwei.
     *
     * @param numeric-string $ether
     *
     * @return numeric-string
     */
    public static function etherToGwei(string $ether): string
    {
        self::validateNumeric($ether, 'Ether');
        // First convert Ether to Wei, then Wei to Gwei
        $wei = self::etherToWei($ether);
        return self::weiToGwei($wei);
    }

    /**
     * Validates if the input is a numeric string.
     */
    private static function validateNumeric(string $value, string $name): void
    {
        if (false === \is_numeric($value)) {
            throw new \InvalidArgumentException("Invalid numeric value for {$name}: {$value}");
        }
    }

    /**
     * Performs multiplication using BCMath.
     *
     * @param numeric-string $a
     * @param numeric-string $b
     *
     * @return numeric-string
     */
    private static function mul(string $a, string $b, int $scale = self::SCALE): string
    {
        return \bcmul($a, $b, $scale);
    }

    /**
     * Performs division using BCMath.
     *
     * @param numeric-string $a
     * @param numeric-string $b
     *
     * @return numeric-string
     */
    private static function div(string $a, string $b, int $scale = self::SCALE): string
    {
        if (\bccomp($b, '0', self::SCALE) === 0) {
            throw new \InvalidArgumentException("Division by zero.");
        }
        return \bcdiv($a, $b, $scale);
    }
}

<?php

declare(strict_types=1);

namespace EthereumPHP\Utils;

/**
 * Handles formatting for precise numbers and hex values.
 *
 * @note Handling of float|int values is not recommended due to precision loss (and integer max size).
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class NumberFormatter
{
    public static function formatWei(float $number): string
    {
        return number_format($number, 0, '.', '');
    }

    public static function hexToWei(string $hex): string
    {
        if (str_starts_with($hex, '0x') || str_starts_with($hex, '0X')) {
            $hex = substr($hex, 2);
        }

        $balanceGMP = gmp_init($hex, 16);

        return gmp_strval($balanceGMP);
    }

    public static function numericToHex(string $wei): string
    {
        $balanceGMP = gmp_init($wei);

        return '0x' . gmp_strval($balanceGMP, 16);
    }
}

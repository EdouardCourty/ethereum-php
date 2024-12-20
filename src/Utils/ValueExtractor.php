<?php

declare(strict_types=1);

namespace EthereumPHP\Utils;

/**
 * Utility class to extract and validate values from raw responses.
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class ValueExtractor
{
    /**
     * Extracts a string from the response.
     */
    public static function getString(bool|int|float|array|string $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        throw new \InvalidArgumentException('Expected a string.');
    }

    /**
     * Extracts an integer from the response.
     */
    public static function getInt(bool|int|float|array|string $value): int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && ctype_digit($value)) {
            return (int) $value;
        }

        throw new \InvalidArgumentException('Expected an integer.');
    }

    /**
     * Extracts a boolean from the response.
     */
    public static function getBool(bool|int|float|array|string $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        throw new \InvalidArgumentException('Expected a boolean.');
    }

    /**
     * Extracts an array from the response.
     */
    public static function getArray(bool|int|float|array|string $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        throw new \InvalidArgumentException('Expected an array.');
    }

    /**
     * Extracts a hexadecimal string and converts it to an integer.
     */
    public static function hexToInt(bool|int|float|array|string $value): int
    {
        if (is_string($value)) {
            // Remove '0x' prefix if present
            $value = preg_replace('/^0x/', '', $value);

            if ($value === null) {
                throw new \InvalidArgumentException('Expected a hexadecimal string.');
            }

            if (ctype_xdigit($value)) {
                return (int) hexdec($value);
            }
        }

        throw new \InvalidArgumentException('Expected a hexadecimal string.');
    }

    /**
     * Extracts a value as a numeric string.
     *
     * @throws \InvalidArgumentException
     * @return numeric-string
     *
     */
    public static function getNumericString(bool|int|float|array|string $value): string
    {
        if (is_numeric($value)) {
            return (string) $value;
        }

        throw new \InvalidArgumentException('Expected a numeric string.');
    }
}

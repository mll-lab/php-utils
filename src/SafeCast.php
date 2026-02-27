<?php declare(strict_types=1);

namespace MLL\Utils;

use function Safe\preg_match;

/**
 * Safe type casting utilities to prevent unexpected or meaningless cast results.
 *
 * PHP's native type casts like (int) and (float) can produce unexpected results,
 * especially when casting from strings. This class provides safe alternatives that
 * validate the input before casting.
 *
 * Example of problematic native casts:
 * - (int)"hello" returns 0 (misleading, not an error)
 * - (int)"123abc" returns 123 (partial conversion, data loss)
 * - (float)"1.23.45" returns 1.23 (invalid format accepted)
 *
 * Each type has two variants:
 * - toX($value): returns the cast value or throws \InvalidArgumentException
 * - tryX($value): returns the cast value or null (like Enum::tryFrom)
 */
class SafeCast
{
    /**
     * Safely cast a value to an integer, or throw.
     *
     * @param mixed $value The value to cast
     */
    public static function toInt($value): int
    {
        return self::tryInt($value)
            ?? throw self::failedToCastToInt($value);
    }

    /**
     * Safely cast a value to an integer, or return null.
     *
     * Only accepts:
     * - Integers (returned as-is)
     * - Numeric strings that represent valid integers
     * - Floats that are exact integer values (e.g., 5.0)
     *
     * @param mixed $value The value to cast
     */
    public static function tryInt($value): ?int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_float($value) && $value === floor($value) && is_finite($value)) {
            return (int) $value;
        }

        if (is_string($value)) {
            $trimmed = trim($value);

            if ($trimmed !== '' && self::isIntegerString($trimmed)) {
                return (int) $trimmed;
            }
        }

        return null;
    }

    /**
     * Safely cast a value to a float, or throw.
     *
     * @param mixed $value The value to cast
     */
    public static function toFloat($value): float
    {
        return self::tryFloat($value)
            ?? throw self::failedToCastToFloat($value);
    }

    /**
     * Safely cast a value to a float, or return null.
     *
     * Only accepts:
     * - Floats (returned as-is)
     * - Integers (cast to float)
     * - Numeric strings that represent valid floats
     *
     * @param mixed $value The value to cast
     */
    public static function tryFloat($value): ?float
    {
        if (is_float($value)) {
            return $value;
        }

        if (is_int($value)) {
            return (float) $value;
        }

        if (is_string($value)) {
            $trimmed = trim($value);

            if ($trimmed !== '' && self::isNumericString($trimmed)) {
                return (float) $trimmed;
            }
        }

        return null;
    }

    /**
     * Safely cast a value to a string, or throw.
     *
     * @param mixed $value The value to cast
     */
    public static function toString($value): string
    {
        return self::tryString($value)
            ?? throw self::failedToCastToString($value);
    }

    /**
     * Safely cast a value to a string, or return null.
     *
     * Only accepts:
     * - Strings (returned as-is)
     * - Integers and floats (converted to string)
     * - Objects with __toString() method
     * - null (converted to empty string)
     *
     * @param mixed $value The value to cast
     */
    public static function tryString($value): ?string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }

        if ($value === null) {
            return '';
        }

        if (is_object($value) && method_exists($value, '__toString')) {
            return (string) $value;
        }

        return null;
    }

    /**
     * Safely cast a value to a boolean, or throw.
     *
     * @param mixed $value The value to cast
     */
    public static function toBool($value): bool
    {
        return self::tryBool($value)
            ?? throw self::failedToCastToBool($value);
    }

    /**
     * Safely cast a value to a boolean, or return null.
     *
     * Only accepts:
     * - Booleans (returned as-is)
     * - Integer 0 or 1
     * - String "0" or "1"
     *
     * @param mixed $value The value to cast
     */
    public static function tryBool($value): ?bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if ($value === 0 || $value === '0') {
            return false;
        }

        if ($value === 1 || $value === '1') {
            return true;
        }

        return null;
    }

    private static function isIntegerString(string $value): bool
    {
        return preg_match('/^[+-]?\d+$/', $value) === 1;
    }

    private static function isNumericString(string $value): bool
    {
        if (! is_numeric($value)) {
            return false;
        }

        // is_numeric accepts some formats we want to reject, like hexadecimal (0x1F) or binary (0b1010)
        return preg_match('/^0[xXbB]/', $value) !== 1;
    }

    /** @param mixed $value The value that failed to cast */
    private static function failedToCastToInt($value): \InvalidArgumentException
    {
        if (is_float($value)) {
            return new \InvalidArgumentException("Float value \"{$value}\" cannot be safely cast to int (not a whole number or not finite)");
        }

        if (is_string($value)) {
            if (trim($value) === '') {
                return new \InvalidArgumentException('Empty string cannot be cast to int');
            }

            return new \InvalidArgumentException("String value \"{$value}\" is not a valid integer format");
        }

        return new \InvalidArgumentException('Cannot cast value of type "' . gettype($value) . '" to int');
    }

    /** @param mixed $value The value that failed to cast */
    private static function failedToCastToFloat($value): \InvalidArgumentException
    {
        if (is_string($value)) {
            if (trim($value) === '') {
                return new \InvalidArgumentException('Empty string cannot be cast to float');
            }

            return new \InvalidArgumentException("String value \"{$value}\" is not a valid numeric format");
        }

        return new \InvalidArgumentException('Cannot cast value of type "' . gettype($value) . '" to float');
    }

    /** @param mixed $value The value that failed to cast */
    private static function failedToCastToString($value): \InvalidArgumentException
    {
        return new \InvalidArgumentException('Cannot cast value of type "' . gettype($value) . '" to string');
    }

    /** @param mixed $value The value that failed to cast */
    private static function failedToCastToBool($value): \InvalidArgumentException
    {
        return new \InvalidArgumentException('Cannot safely cast value of type "' . gettype($value) . '" to bool. Only bool, int 0/1, or string "0"/"1" are accepted.');
    }
}

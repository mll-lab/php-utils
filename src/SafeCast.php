<?php declare(strict_types=1);

namespace MLL\Utils;

use Safe\Exceptions\PcreException;

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
 * The methods in this class throw exceptions for invalid inputs instead of
 * silently producing incorrect values.
 */
class SafeCast
{
    /**
     * Safely cast a value to an integer.
     *
     * Only accepts:
     * - Integers (returned as-is)
     * - Numeric strings that represent valid integers
     * - Floats that are exact integer values (e.g., 5.0)
     *
     * @param mixed $value The value to cast
     *
     * @throws \InvalidArgumentException If the value cannot be safely cast to an integer
     */
    public static function toInt($value): int
    {
        if (is_int($value)) {
            return $value;
        }

        // Allow floats that represent exact integers (e.g., 5.0 -> 5)
        if (is_float($value)) {
            if ($value === floor($value) && is_finite($value)) {
                return (int) $value;
            }

            throw new \InvalidArgumentException('Float value "' . $value . '" cannot be safely cast to int (not a whole number or not finite)');
        }

        if (is_string($value)) {
            $trimmed = trim($value);

            // Empty string is not a valid integer
            if ($trimmed === '') {
                throw new \InvalidArgumentException('Empty string cannot be cast to int');
            }

            // Check if the string represents a valid integer
            if (! self::isIntegerString($trimmed)) {
                throw new \InvalidArgumentException('String value "' . $value . '" is not a valid integer format');
            }

            return (int) $trimmed;
        }

        throw new \InvalidArgumentException('Cannot cast value of type "' . gettype($value) . '" to int');
    }

    /**
     * Safely cast a value to a float.
     *
     * Only accepts:
     * - Floats (returned as-is)
     * - Integers (cast to float)
     * - Numeric strings that represent valid floats
     *
     * @param mixed $value The value to cast
     *
     * @throws \InvalidArgumentException If the value cannot be safely cast to a float
     */
    public static function toFloat($value): float
    {
        if (is_float($value)) {
            return $value;
        }

        if (is_int($value)) {
            return (float) $value;
        }

        if (is_string($value)) {
            $trimmed = trim($value);

            // Empty string is not a valid float
            if ($trimmed === '') {
                throw new \InvalidArgumentException('Empty string cannot be cast to float');
            }

            // Check if the string represents a valid numeric value
            if (! self::isNumericString($trimmed)) {
                throw new \InvalidArgumentException('String value "' . $value . '" is not a valid numeric format');
            }

            return (float) $trimmed;
        }

        throw new \InvalidArgumentException('Cannot cast value of type "' . gettype($value) . '" to float');
    }

    /**
     * Safely cast a value to a string.
     *
     * Only accepts:
     * - Strings (returned as-is)
     * - Integers and floats (converted to string)
     * - Objects with __toString() method
     * - null (converted to empty string)
     *
     * @param mixed $value The value to cast
     *
     * @throws \InvalidArgumentException If the value cannot be safely cast to a string
     */
    public static function toString($value): string
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

        throw new \InvalidArgumentException('Cannot cast value of type "' . gettype($value) . '" to string');
    }

    /**
     * Check if a string represents a valid integer.
     *
     * Accepts optional leading/trailing whitespace, optional sign, and digits only.
     */
    private static function isIntegerString(string $value): bool
    {
        try {
            return preg_match('/^[+-]?\d+$/', $value) === 1;
        } catch (PcreException $ex) {
            return false;
        }
    }

    /**
     * Check if a string represents a valid numeric value (integer or float).
     *
     * Accepts scientific notation, decimals with optional sign.
     */
    private static function isNumericString(string $value): bool
    {
        // Use is_numeric() but verify it's not in a weird format
        if (! is_numeric($value)) {
            return false;
        }

        // is_numeric accepts some formats we might want to reject
        // like hexadecimal (0x1F) or binary (0b1010)
        // Check for these and reject them for stricter validation
        try {
            $hasHexOrBinary = preg_match('/^0[xXbB]/', $value) === 1;

            return ! $hasHexOrBinary;
        } catch (PcreException $ex) {
            return false;
        }
    }
}

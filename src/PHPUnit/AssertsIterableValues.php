<?php declare(strict_types=1);

namespace MLL\Utils\PHPUnit;

use PHPUnit\Framework\Assert;

/**
 * Requires the package phpunit/phpunit.
 */
trait AssertsIterableValues
{
    /**
     * Asserts that two iterables contain the same values in the same order, ignoring keys.
     *
     * Iterable counterpart of PHPUnit 13's assertArraysHaveIdenticalValues().
     *
     * @param iterable<mixed> $expected
     * @param iterable<mixed> $actual
     */
    public static function assertIterablesHaveIdenticalValues(iterable $expected, iterable $actual, string $message = ''): void
    {
        Assert::assertSame(
            self::iterableValues($expected),
            self::iterableValues($actual),
            $message,
        );
    }

    /**
     * @param iterable<mixed> $iterable
     *
     * @return list<mixed>
     */
    private static function iterableValues(iterable $iterable): array
    {
        $values = [];
        foreach ($iterable as $value) {
            $values[] = $value;
        }

        return $values;
    }
}

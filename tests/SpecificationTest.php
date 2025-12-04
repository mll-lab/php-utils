<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\Specification;
use PHPUnit\Framework\TestCase;

final class SpecificationTest extends TestCase
{
    public function testNot(): void
    {
        $truthy = fn (string $value): bool => (bool) $value;

        self::assertTrue($truthy('truthy'));

        $negatedIdentity = Specification::not($truthy);
        self::assertFalse($negatedIdentity('truthy'));
    }

    public function testOr(): void
    {
        $is1 = fn (int $value): bool => $value === 1;
        $is2 = fn (int $value): bool => $value === 2;

        $is1Or2 = Specification::or($is1, $is2);
        self::assertTrue($is1Or2(1));
        self::assertTrue($is1Or2(2));
        self::assertFalse($is1Or2(3));
    }

    public function testAnd(): void
    {
        $isPositive = fn (int $value): bool => $value > 0;
        $isOdd = fn (int $value): bool => $value % 2 === 1;

        $isPositiveAndOdd = Specification::and($isPositive, $isOdd);
        self::assertTrue($isPositiveAndOdd(1));
        self::assertFalse($isPositiveAndOdd(2));
        self::assertFalse($isPositiveAndOdd(-1));
        self::assertFalse($isPositiveAndOdd(0));
        self::assertFalse($isPositiveAndOdd(-2));
    }
}

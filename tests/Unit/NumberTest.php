<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Unit;

use MLL\Utils\Number;
use PHPUnit\Framework\TestCase;

final class NumberTest extends TestCase
{
    /**
     * @dataProvider clampProvider
     *
     * @param float|int $min
     * @param float|int $max
     * @param float|int $current
     * @param float|int $expected
     */
    public function testClamp($min, $max, $current, $expected): void
    {
        self::assertSame($expected, Number::clamp($min, $max, $current));
    }

    /**
     * @return iterable<array{int|float, int|float, int|float, int|float}>
     */
    public function clampProvider(): iterable
    {
        yield [1, 2, 3, 2];
        yield [1, 2, 0, 1];
        yield [-1, 2, 0, 0];
        yield [1, 3, 2, 2];
        yield [0.001, 0.003, 0.002, 0.002];
        yield [0.001, 0.003, 0.004, 0.003];
        yield [0.001, 0.003, 0.000, 0.001];
        yield [-1, +1, 0, 0];
        yield [-1, +1, 0.5, 0.5];
        yield [-1, +1, -2, -1];
    }
}

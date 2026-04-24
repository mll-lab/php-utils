<?php declare(strict_types=1);

namespace MLL\Utils\Tests\InterOp;

use MLL\Utils\InterOp\DeviationValue;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class DeviationValueTest extends TestCase
{
    /** @dataProvider parseProvider */
    #[DataProvider('parseProvider')]
    public function testParse(string $input, ?float $expectedValue, ?float $expectedDeviation): void
    {
        $result = DeviationValue::parse($input);

        if ($expectedValue === null) {
            self::assertNull($result);

            return;
        }

        self::assertNotNull($result);
        self::assertSame($expectedValue, $result->value);
        self::assertSame($expectedDeviation, $result->deviation);
    }

    /** @return iterable<string, array{string, float|null, float|null}> */
    public static function parseProvider(): iterable
    {
        yield 'integer values' => ['851 +/- 32', 851.0, 32.0];
        yield 'decimal values' => ['96.54 +/- 0.25', 96.54, 0.25];
        yield 'nan returns null' => ['nan +/- nan', null, null];
        yield 'small decimal values' => ['0.085 +/- 0.020', 0.085, 0.02];
    }
}

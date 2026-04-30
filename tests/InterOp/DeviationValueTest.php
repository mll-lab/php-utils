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

    public function testAverage(): void
    {
        $a = new DeviationValue(100.0, 10.0);
        $b = new DeviationValue(200.0, 30.0);

        $avg = DeviationValue::average($a, $b);

        self::assertSame(150.0, $avg->value);
        self::assertSame(20.0, $avg->deviation);
    }

    /** @return iterable<string, array{input: string, expectedValue: float|null, expectedDeviation: float|null}> */
    public static function parseProvider(): iterable
    {
        yield 'integer values' => ['input' => '851 +/- 32', 'expectedValue' => 851.0, 'expectedDeviation' => 32.0];
        yield 'decimal values' => ['input' => '96.54 +/- 0.25', 'expectedValue' => 96.54, 'expectedDeviation' => 0.25];
        yield 'nan returns null' => ['input' => 'nan +/- nan', 'expectedValue' => null, 'expectedDeviation' => null];
        yield 'small decimal values' => ['input' => '0.085 +/- 0.020', 'expectedValue' => 0.085, 'expectedDeviation' => 0.02];
    }
}

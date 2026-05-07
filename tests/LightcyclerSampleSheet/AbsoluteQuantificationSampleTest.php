<?php declare(strict_types=1);

namespace MLL\Utils\Tests\LightcyclerSampleSheet;

use MLL\Utils\LightcyclerSampleSheet\AbsoluteQuantificationSample;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class AbsoluteQuantificationSampleTest extends TestCase
{
    /** @dataProvider concentrationFormattingProvider */
    #[DataProvider('concentrationFormattingProvider')]
    public function testFormatConcentration(?float $input, ?string $expected): void
    {
        $result = AbsoluteQuantificationSample::formatConcentration($input);

        self::assertSame($expected, $result);
    }

    /** @return iterable<array{int|float|null, ?string}> */
    public static function concentrationFormattingProvider(): iterable
    {
        yield 'null concentration returns null' => [null, null];
        yield 'zero concentration' => [0, '0.00E0'];
        yield 'zero float concentration' => [0.0, '0.00E0'];
        yield 'small positive number' => [1, '1.00E0'];
        yield 'ten' => [10, '1.00E1'];
        yield 'hundred' => [100, '1.00E2'];
        yield 'four hundred (common lab value)' => [400, '4.00E2'];
        yield 'thousand' => [1000, '1.00E3'];
        yield 'ten thousand' => [10000, '1.00E4'];
        yield 'million' => [1000000, '1.00E6'];
        yield 'large number' => [12345678, '1.23E7'];
        yield 'float twenty' => [20.0, '2.00E1'];
        yield 'float two' => [2.0, '2.00E0'];
        yield 'sub-one float' => [0.2, '2.00E-1'];
        yield 'small float' => [0.02, '2.00E-2'];
        yield 'very small float' => [0.002, '2.00E-3'];
        yield 'tiny float' => [0.0002, '2.00E-4'];
    }
}

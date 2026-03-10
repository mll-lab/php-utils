<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Concentration;

use MLL\Utils\Concentration\MolarityConverter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MolarityConverterTest extends TestCase
{
    /** @dataProvider conversionPairs */
    #[DataProvider('conversionPairs')]
    public function testNgPerUlToNmolPerL(float $expectedNmolPerL, float $ngPerUl, int $fragmentSizeBp): void
    {
        $result = MolarityConverter::ngPerUlToNmolPerL($ngPerUl, $fragmentSizeBp);
        self::assertEqualsWithDelta($expectedNmolPerL, $result, 0.1);
    }

    /** @dataProvider conversionPairs */
    #[DataProvider('conversionPairs')]
    public function testRoundTrip(float $expectedNmolPerL, float $ngPerUl, int $fragmentSizeBp): void
    {
        $nmolPerL = MolarityConverter::ngPerUlToNmolPerL($ngPerUl, $fragmentSizeBp);
        $backToNgPerUl = MolarityConverter::nmolPerLToNgPerUl($nmolPerL, $fragmentSizeBp);
        self::assertEqualsWithDelta($ngPerUl, $backToNgPerUl, 0.001);
    }

    public function testThrowsOnZeroFragmentSize(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Fragment size must be positive');

        MolarityConverter::ngPerUlToNmolPerL(10.0, 0);
    }

    public function testThrowsOnNegativeFragmentSize(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Fragment size must be positive');

        MolarityConverter::nmolPerLToNgPerUl(10.0, -100);
    }

    /** @return iterable<string, array{float, float, int}> */
    public static function conversionPairs(): iterable
    {
        // Values verified against TapeStation Excel pooling sheet
        yield 'FLT3-ITD sample 11.4 ng/µl, 489 bp' => [35.3, 11.4, 489];
        yield 'FLT3-ITD sample 9.35 ng/µl, 491 bp' => [28.9, 9.35, 491];
        yield 'Immunoreceptor TRB 400 bp' => [37.9, 10.0, 400];
        yield 'Immunoreceptor TRG 300 bp' => [50.5, 10.0, 300];
        yield 'Low concentration' => [0.09, 0.03, 488];
    }
}

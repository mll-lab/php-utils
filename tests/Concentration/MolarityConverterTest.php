<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Concentration;

use MLL\Utils\Concentration\MolarityConverter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MolarityConverterTest extends TestCase
{
    /** @dataProvider conversionPairs */
    #[DataProvider('conversionPairs')]
    public function testConcentrationToMolarity(float $expectedNmolPerL, float $ngPerUl, int $fragmentSizeBp): void
    {
        $result = MolarityConverter::concentrationToMolarity($ngPerUl, $fragmentSizeBp, MolarityConverter::DALTONS_PER_BASE_PAIR_DSDNA);
        self::assertEqualsWithDelta($expectedNmolPerL, $result, 0.1);
    }

    /** @dataProvider conversionPairs */
    #[DataProvider('conversionPairs')]
    public function testRoundTrip(float $expectedNmolPerL, float $ngPerUl, int $fragmentSizeBp): void
    {
        $nmolPerL = MolarityConverter::concentrationToMolarity($ngPerUl, $fragmentSizeBp, MolarityConverter::DALTONS_PER_BASE_PAIR_DSDNA);
        $backToNgPerUl = MolarityConverter::molarityToConcentration($nmolPerL, $fragmentSizeBp, MolarityConverter::DALTONS_PER_BASE_PAIR_DSDNA);
        self::assertEqualsWithDelta($ngPerUl, $backToNgPerUl, 0.001);
    }

    public function testThrowsOnZeroFragmentSize(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Fragment size must be positive');

        MolarityConverter::concentrationToMolarity(10.0, 0, MolarityConverter::DALTONS_PER_BASE_PAIR_DSDNA);
    }

    public function testThrowsOnNegativeFragmentSize(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Fragment size must be positive');

        MolarityConverter::molarityToConcentration(10.0, -100, MolarityConverter::DALTONS_PER_BASE_PAIR_DSDNA);
    }

    public function testThrowsOnZeroDaltonsPerUnit(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Daltons per unit must be positive');

        MolarityConverter::concentrationToMolarity(10.0, 400, 0.0);
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

<?php declare(strict_types=1);

namespace MLL\Utils\Concentration;

class MolarityConverter
{
    public const DALTONS_PER_BASE_PAIR_DSDNA = 660.0;
    public const DALTONS_PER_NUCLEOTIDE_SSDNA = 330.0;
    public const DALTONS_PER_NUCLEOTIDE_RNA = 340.0;

    public static function massConcentrationToMolarity(
        float $concentrationNgPerUl,
        float $averageFragmentSize,
        float $averageDaltonsPerUnit
    ): float {
        self::assertPositive($averageFragmentSize, 'Fragment size');
        self::assertPositive($averageDaltonsPerUnit, 'Daltons per unit');

        return ($concentrationNgPerUl / ($averageDaltonsPerUnit * $averageFragmentSize)) * 1_000_000;
    }

    public static function molarityToMassConcentration(
        float $molarityNmolPerL,
        float $averageFragmentSize,
        float $averageDaltonsPerUnit
    ): float {
        self::assertPositive($averageFragmentSize, 'Fragment size');
        self::assertPositive($averageDaltonsPerUnit, 'Daltons per unit');

        return ($molarityNmolPerL * $averageDaltonsPerUnit * $averageFragmentSize) / 1_000_000;
    }

    private static function assertPositive(float $value, string $name): void
    {
        if ($value <= 0.0) {
            throw new \InvalidArgumentException("{$name} must be positive, got {$value}");
        }
    }
}

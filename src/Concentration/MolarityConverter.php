<?php declare(strict_types=1);

namespace MLL\Utils\Concentration;

class MolarityConverter
{
    /** Average molar mass of a single base pair in double-stranded DNA (g/mol). */
    public const AVERAGE_DALTONS_PER_BASE_PAIR = 660.0;

    /** Convert mass concentration (ng/µL) to molar concentration (nmol/L). */
    public static function ngPerUlToNmolPerL(float $concentrationNgPerUl, float $averageFragmentSize): float
    {
        self::assertPositiveFragmentSize($averageFragmentSize);

        return ($concentrationNgPerUl / (self::AVERAGE_DALTONS_PER_BASE_PAIR * $averageFragmentSize)) * 1_000_000;
    }

    /** Convert molar concentration (nmol/L) to mass concentration (ng/µL). */
    public static function nmolPerLToNgPerUl(float $molarityNmolPerL, float $averageFragmentSize): float
    {
        self::assertPositiveFragmentSize($averageFragmentSize);

        return ($molarityNmolPerL * self::AVERAGE_DALTONS_PER_BASE_PAIR * $averageFragmentSize) / 1_000_000;
    }

    private static function assertPositiveFragmentSize(float $averageFragmentSize): void
    {
        if ($averageFragmentSize <= 0.0) {
            throw new \InvalidArgumentException("Fragment size must be positive, got {$averageFragmentSize}");
        }
    }
}

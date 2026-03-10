<?php declare(strict_types=1);

namespace MLL\Utils\Concentration;

class MolarityConverter
{
    /** Average molar mass of a single base pair in double-stranded DNA (g/mol). */
    public const AVERAGE_DALTONS_PER_BASE_PAIR = 660.0;

    /** Convert mass concentration (ng/µL) to molar concentration (nmol/L). */
    public static function ngPerUlToNmolPerL(float $concentrationNgPerUl, int $averageFragmentSizeBp): float
    {
        assert($averageFragmentSizeBp > 0);

        return ($concentrationNgPerUl / (self::AVERAGE_DALTONS_PER_BASE_PAIR * $averageFragmentSizeBp)) * 1_000_000;
    }

    /** Convert molar concentration (nmol/L) to mass concentration (ng/µL). */
    public static function nmolPerLToNgPerUl(float $molarityNmolPerL, int $averageFragmentSizeBp): float
    {
        assert($averageFragmentSizeBp > 0);

        return ($molarityNmolPerL * self::AVERAGE_DALTONS_PER_BASE_PAIR * $averageFragmentSizeBp) / 1_000_000;
    }
}

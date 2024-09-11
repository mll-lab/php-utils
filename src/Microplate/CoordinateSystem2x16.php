<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

class CoordinateSystem2x16 extends CoordinateSystem
{
    /** Duplicates @see CoordinateSystem::positionsCount() for static contexts. */
    public const POSITIONS_COUNT = 32;

    public function rows(): array
    {
        return range('A', 'P');
    }

    public function columns(): array
    {
        return range(1, 2);
    }
}

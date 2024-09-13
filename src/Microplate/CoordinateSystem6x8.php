<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

class CoordinateSystem6x8 extends CoordinateSystem
{
    /** Duplicates @see CoordinateSystem::positionsCount() for static contexts. */
    public const POSITIONS_COUNT = 48;

    public function rows(): array
    {
        return range('A', 'H');
    }

    public function columns(): array
    {
        return range(1, 6);
    }
}

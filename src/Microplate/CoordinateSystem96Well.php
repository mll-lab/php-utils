<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

class CoordinateSystem96Well extends CoordinateSystem
{
    /** Duplicates @see CoordinateSystem::positionsCount() for static contexts. */
    public const POSITIONS_COUNT = 96;

    public function rows(): array
    {
        return range('A', 'H');
    }

    public function columns(): array
    {
        return range(1, 12);
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

final class CoordinateSystem12Well extends CoordinateSystem
{
    /** Duplicates @see CoordinateSystem::positionsCount() for static contexts. */
    public const POSITIONS_COUNT = 12;

    public function rows(): array
    {
        return range('A', 'C');
    }

    public function columns(): array
    {
        return range(1, 4);
    }
}

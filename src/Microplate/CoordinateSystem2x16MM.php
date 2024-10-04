<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

class CoordinateSystem2x16MM extends CoordinateSystem
{
    /** Duplicates @see CoordinateSystem::positionsCount() for static contexts. */
    public const POSITIONS_COUNT = 32;

    public function rows(): array
    {
        return ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'Q'];
    }

    public function columns(): array
    {
        return range(1, 2);
    }
}

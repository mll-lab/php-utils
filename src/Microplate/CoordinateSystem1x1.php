<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

class CoordinateSystem1x1 extends CoordinateSystem
{
    /** Duplicates @see CoordinateSystem::positionsCount() for static contexts. */
    public const POSITIONS_COUNT = 1;

    public function rows(): array
    {
        return ['A'];
    }

    public function columns(): array
    {
        return [1];
    }
}

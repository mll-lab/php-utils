<?php declare(strict_types=1);

namespace MLL\Utils\Microplate;

class CoordinateSystem2x16NoJ extends CoordinateSystem
{
    /** Duplicates @see CoordinateSystem::positionsCount() for static contexts. */
    public const POSITIONS_COUNT = 32;

    /** The Tecan MM block has no J on its rows */
    public function rows(): array
    {
        return [...range('A', 'I'), ...range('K', 'Q')];
    }

    public function columns(): array
    {
        return range(1, 2);
    }
}

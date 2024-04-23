<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\MicroplateSet;

use MLL\Utils\Microplate\CoordinateSystem;

/**
 * @template TCoordinateSystem of CoordinateSystem
 *
 * @phpstan-extends MicroplateSet<TCoordinateSystem>
 */
class MicroplateSetABCD extends MicroplateSet
{
    /** Duplicates @see MicroplateSet::plateCount() for static contexts. */
    public const PLATE_COUNT = 4;

    public function plateIDs(): array
    {
        return ['A', 'B', 'C', 'D'];
    }
}

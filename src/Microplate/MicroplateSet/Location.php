<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\MicroplateSet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem;

/** @template TCoordinateSystem of CoordinateSystem */
class Location
{
    /** @param \MLL\Utils\Microplate\Coordinates<TCoordinateSystem> $coordinates */
    public function __construct(
        public Coordinates $coordinates,
        public string $plateID
    ) {}
}

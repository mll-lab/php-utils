<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\MicroplateSet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem;

/**
 * @template TCoordinateSystem of CoordinateSystem
 */
class Location
{
    public string $plateID;

    /** @var \MLL\Utils\Microplate\Coordinates<TCoordinateSystem> */
    public Coordinates $coordinates;

    /** @param \MLL\Utils\Microplate\Coordinates<TCoordinateSystem> $coordinates */
    public function __construct(Coordinates $coordinates, string $plateID)
    {
        $this->coordinates = $coordinates;
        $this->plateID = $plateID;
    }
}

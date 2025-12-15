<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerExportSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class LightcyclerSample
{
    /** @param Coordinates<CoordinateSystem12x8> $coordinates */
    public function __construct(
        public string $name,
        public Coordinates $coordinates,
        public float $calculatedConcentration,
        public float $crossingPoint,
        public ?float $standardConcentration = null
    ) {}
}

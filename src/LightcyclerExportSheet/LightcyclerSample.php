<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerExportSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class LightcyclerSample
{
    public string $name;

    /** @var Coordinates<CoordinateSystem12x8> */
    public Coordinates $coordinates;

    public float $calculatedConcentration;

    public float $crossingPoint;

    public ?float $standardConcentration;

    /** @param Coordinates<CoordinateSystem12x8> $coordinates */
    public function __construct(
        string $name,
        Coordinates $coordinates,
        float $calculatedConcentration,
        float $crossingPoint,
        ?float $standardConcentration = null
    ) {
        $this->standardConcentration = $standardConcentration;
        $this->crossingPoint = $crossingPoint;
        $this->calculatedConcentration = $calculatedConcentration;
        $this->coordinates = $coordinates;
        $this->name = $name;
    }
}

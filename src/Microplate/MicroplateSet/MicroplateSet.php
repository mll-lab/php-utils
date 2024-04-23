<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\MicroplateSet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem;
use MLL\Utils\Microplate\Enums\FlowDirection;

/**
 *  @template TCoordinateSystem of CoordinateSystem
 */
abstract class MicroplateSet
{
    /** @var TCoordinateSystem */
    public CoordinateSystem $coordinateSystem;

    /** @param TCoordinateSystem $coordinateSystem */
    public function __construct(CoordinateSystem $coordinateSystem)
    {
        $this->coordinateSystem = $coordinateSystem;
    }

    /** @return list<string> */
    abstract public function plateIDs(): array;

    public function plateCount(): int
    {
        return count($this->plateIDs());
    }

    public function positionsCount(): int
    {
        return $this->coordinateSystem->positionsCount() * $this->plateCount();
    }

    /** @return Location<TCoordinateSystem> */
    public function locationFromPosition(int $setPosition, FlowDirection $direction): Location
    {
        $positionsCount = $this->positionsCount();
        if ($setPosition > $positionsCount || $setPosition < Coordinates::MIN_POSITION) {
            throw new \OutOfRangeException("Expected a position between 1-{$positionsCount}, got: {$setPosition}.");
        }

        $plateIndex = (int) floor(($setPosition - 1) / $this->coordinateSystem->positionsCount());
        $positionOnSinglePlate = $setPosition - ($plateIndex * $this->coordinateSystem->positionsCount());

        /** @phpstan-ignore-next-line Generic inference is too weak to recognize this code is correct */
        return new Location(
            Coordinates::fromPosition($positionOnSinglePlate, $direction, $this->coordinateSystem),
            $this->plateIDs()[$plateIndex]
        );
    }
}

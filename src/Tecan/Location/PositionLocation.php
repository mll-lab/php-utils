<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Location;

use MLL\Utils\Tecan\Rack\Rack;

class PositionLocation implements Location
{
    private int $position;

    private Rack $rack;

    public function __construct(int $position, Rack $rack)
    {
        $this->position = $position;
        $this->rack = $rack;
    }

    public function tubeID(): ?string
    {
        return null;
    }

    public function position(): string
    {
        return (string) $this->position;
    }

    public function rackName(): ?string
    {
        return $this->rack->name();
    }

    public function rackType(): string
    {
        return $this->rack->type();
    }

    public function rackID(): ?string
    {
        return null;
    }

    public function toString(): string
    {
        return implode(
            ';',
            [
                $this->rackName(),
                $this->rackID(),
                $this->rackType(),
                $this->position(),
                $this->tubeID(),
            ]
        );
    }
}

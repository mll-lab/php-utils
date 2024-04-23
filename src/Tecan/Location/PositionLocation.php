<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Location;

use MLL\Utils\Tecan\Rack\Rack;

final class PositionLocation implements Location
{
    private int $position;

    private Rack $rack;

    public function __construct(int $position, Rack $rack)
    {
        $this->position = $position;
        $this->rack = $rack;
    }

    public function tubeId(): ?string
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

    public function rackId(): ?string
    {
        return null;
    }

    public function toString(): string
    {
        return implode(
            ';',
            [
                $this->rackName(),
                $this->rackId(),
                $this->rackType(),
                $this->position(),
                $this->tubeId(),
            ]
        );
    }
}

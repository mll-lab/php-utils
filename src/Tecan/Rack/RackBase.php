<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

abstract class RackBase implements Rack
{
    public function id(): ?string
    {
        return null;
    }

    public function toString(): string
    {
        return implode(
            ';',
            [
                $this->name(),
                $this->id(),
                $this->type(),
            ]
        );
    }
}

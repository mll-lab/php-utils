<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class DestLC extends RackBase
{
    public function type(): string
    {
        return '96 Well MP LightCycler480';
    }

    public function name(): string
    {
        return 'DestLC';
    }

    public function positionCount(): int
    {
        return 96;
    }
}

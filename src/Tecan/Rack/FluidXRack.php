<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class FluidXRack extends BaseRack implements ScannedRack
{
    public function type(): string
    {
        return '96FluidX';
    }

    public function name(): string
    {
        return 'FluidX';
    }

    public function positionCount(): int
    {
        return 96;
    }
}

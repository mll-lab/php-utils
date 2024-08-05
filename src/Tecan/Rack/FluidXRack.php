<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class FluidXRack extends RackBase implements ScannedRack
{
    public function type(): string
    {
        return '96FluidX';
    }

    public function name(): string
    {
        return 'FluidX';
    }
}

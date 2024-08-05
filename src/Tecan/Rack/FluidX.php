<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class FluidX extends RackBase
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

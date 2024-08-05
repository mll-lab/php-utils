<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class MasterMixRack extends RackBase
{
    public function type(): string
    {
        return 'Eppis 32x1.5 ml Cooled';
    }

    public function name(): string
    {
        return 'MM';
    }

    public function positionCount(): int
    {
        return 32;
    }
}

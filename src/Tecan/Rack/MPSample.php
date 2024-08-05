<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class MPSample extends RackBase
{
    public function type(): string
    {
        return 'MP Microplate';
    }

    public function name(): string
    {
        return 'MPSample';
    }

    public function positionCount(): int
    {
        return 96;
    }
}

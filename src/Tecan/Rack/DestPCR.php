<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class DestPCR extends RackBase
{
    public function type(): string
    {
        return '96 Well PCR ABI semi-skirted';
    }

    public function name(): string
    {
        return 'DestPCR';
    }

    public function positionCount(): int
    {
        return 96;
    }
}

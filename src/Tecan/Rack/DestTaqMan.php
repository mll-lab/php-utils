<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class DestTaqMan extends RackBase
{
    public function type(): string
    {
        return '96 Well PCR TaqMan';
    }

    public function name(): string
    {
        return 'DestTaqMan';
    }

    public function positionCount(): int
    {
        return 96;
    }
}

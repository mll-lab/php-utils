<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

class MPWater extends RackBase
{
    public function type(): string
    {
        return 'Trough 300ml MCA Portrait';
    }

    public function name(): string
    {
        return 'MPWasser';
    }
}
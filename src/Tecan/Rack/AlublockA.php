<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class AlublockA extends BaseRack
{
    public function type(): string
    {
        return 'Eppis 24x0.5 ml Cooled';
    }

    public function name(): string
    {
        return 'A';
    }

    public function positionCount(): int
    {
        return 24;
    }
}

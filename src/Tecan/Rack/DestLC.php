<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class DestLC extends BaseRack
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

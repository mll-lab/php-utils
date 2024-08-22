<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
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

<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class MPSample extends BaseRack
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

<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\Rack;

/**
 * @template TContent
 *
 * @extends BaseRack<TContent>
 */
class MPCDNA extends BaseRack
{
    public function type(): string
    {
        return 'MP cDNA';
    }

    public function name(): string
    {
        return 'MPCDNA';
    }

    public function positionCount(): int
    {
        return 96;
    }
}

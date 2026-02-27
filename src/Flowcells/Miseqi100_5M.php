<?php declare(strict_types=1);

namespace MLL\Utils\Flowcells;

class Miseqi100_5M extends FlowcellType
{
    public function totalLaneCount(): int
    {
        return 1;
    }

    public function name(): string
    {
        return '5M';
    }
}

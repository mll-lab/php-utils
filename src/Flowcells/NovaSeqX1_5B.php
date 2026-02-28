<?php declare(strict_types=1);

namespace MLL\Utils\Flowcells;

class NovaSeqX1_5B extends FlowcellType
{
    public function totalLaneCount(): int
    {
        return 2;
    }

    public function name(): string
    {
        return '1.5B';
    }
}

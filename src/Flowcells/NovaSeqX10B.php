<?php declare(strict_types=1);

namespace MLL\Utils\Flowcells;

class NovaSeqX10B extends FlowcellType
{
    public function totalLaneCount(): int
    {
        return 8;
    }

    public function name(): string
    {
        return '10B';
    }
}

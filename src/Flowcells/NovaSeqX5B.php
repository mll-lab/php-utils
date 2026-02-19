<?php

namespace MLL\Utils\Flowcells;

class NovaSeqX5B extends FlowcellType
{
    public function totalLaneCount(): int
    {
        return 8;
    }

    public function name(): string
    {
        return '5B';
    }
}
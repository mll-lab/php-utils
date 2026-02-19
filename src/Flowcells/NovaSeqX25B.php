<?php

namespace MLL\Utils\Flowcells;

class NovaSeqX25B extends FlowcellType
{
    public function totalLaneCount(): int
    {
        return 8;
    }

    public function name(): string
    {
        return '25B';
    }
}
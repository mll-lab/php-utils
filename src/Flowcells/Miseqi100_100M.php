<?php

namespace MLL\Utils\Flowcells;

class Miseqi100_100M extends FlowcellType
{
    public function totalLaneCount(): int
    {
        return 1;
    }

    public function name(): string
    {
        return '100M';
    }
}
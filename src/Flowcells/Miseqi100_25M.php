<?php

namespace MLL\Utils\Flowcells;

class Miseqi100_25M extends FlowcellType
{
    public function totalLaneCount(): int
    {
        return 1;
    }

    public function name(): string
    {
        return '25M';
    }
}
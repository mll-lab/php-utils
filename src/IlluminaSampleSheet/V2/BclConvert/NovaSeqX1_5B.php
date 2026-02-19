<?php

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

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
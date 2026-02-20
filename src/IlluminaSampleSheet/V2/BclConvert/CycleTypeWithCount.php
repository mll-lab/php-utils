<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class CycleTypeWithCount
{
    public CycleType $cycleType;

    public int $count;

    public function __construct(CycleType $cycleType, int $count)
    {
        $this->cycleType = $cycleType;
        $this->count = $count;
    }

    public function toString(): string
    {
        return $this->cycleType->value . $this->count;
    }
}

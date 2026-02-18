<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class CycleTypeWithCount
{
    public function __construct(
        public CycleType $cycleType,
        public int $count
    ) {}

    public function toString(): string
    {
        return $this->cycleType->value . $this->count;
    }
}

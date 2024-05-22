<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class OverrideCycle
{
    /** @var array<CycleTypeWithCount> */
    public array $cycles;

    /** @param array<CycleTypeWithCount> $firstCycle */
    public function __construct(array $firstCycle)
    {
        $this->cycles = $firstCycle;
    }

    public function toString(): string
    {
        return implode('', array_map(
            fn (CycleTypeWithCount $cycle): string => $cycle->toString(),
            $this->cycles
        ));
    }
}

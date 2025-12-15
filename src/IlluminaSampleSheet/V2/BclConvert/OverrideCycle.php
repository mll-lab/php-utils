<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;

class OverrideCycle
{
    /** @param array<CycleTypeWithCount> $cycles */
    public function __construct(
        public array $cycles
    ) {}

    /** @param bool|null $isSecondIndexAndForwardDirection null if it is not the secondIndex, true if it is the secondIndex and forwardDirection, false if it is the secondIndex and reverseDirection */
    public function toString(int $fillUpToMax, ?bool $isSecondIndexAndForwardDirection): string
    {
        $countOfAllCycleTypes = $this->sumCountOfAllCycles();
        if ($countOfAllCycleTypes > $fillUpToMax) {
            throw new IlluminaSampleSheetException("The sum of all cycle types must be less than or equal to the fill up to max value. \$countOfAllCycleTypes: {$countOfAllCycleTypes} > \$fillUpToMax: {$fillUpToMax}");
        }
        $rawOverrideCycle = implode('', array_map(
            fn (CycleTypeWithCount $cycle): string => $cycle->toString(),
            $this->cycles
        ));

        if ($countOfAllCycleTypes === $fillUpToMax) {
            return $rawOverrideCycle;
        }

        $remainingCycles = 'N' . ($fillUpToMax - $countOfAllCycleTypes);

        return (bool) $isSecondIndexAndForwardDirection
            ? $remainingCycles . $rawOverrideCycle
            : $rawOverrideCycle . $remainingCycles;
    }

    public function sumCountOfAllCycles(): int
    {
        return array_sum(
            array_map(
                fn (CycleTypeWithCount $cycleTypeWithCount): int => $cycleTypeWithCount->count,
                $this->cycles
            )
        );
    }
}

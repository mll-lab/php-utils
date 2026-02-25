<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;

class OverrideCycle
{
    /** @var array<int, CycleTypeWithCount> */
    public array $cycleTypeWithCountList;

    public IndexOrientation $indexOrientation;

    /** @param array<int, CycleTypeWithCount> $cycleTypeWithCountList */
    public function __construct(array $cycleTypeWithCountList, IndexOrientation $indexOrientation)
    {
        $this->cycleTypeWithCountList = $cycleTypeWithCountList;
        $this->indexOrientation = $indexOrientation;
    }

    public static function fromString(
        string $cycleString,
        IndexOrientation $indexOrientation
    ): self {
        \Safe\preg_match_all('/([YNUI])(\d+)/', $cycleString, $matches, PREG_SET_ORDER);

        if (count($matches) > 4) {
            throw new IlluminaSampleSheetException("Invalid Override Cycle Part. Should have at most 4 parts: {$cycleString}.");
        }

        if (count($matches) === 0) {
            throw new IlluminaSampleSheetException("Invalid Override Cycle Part. Should have at least 1 part: {$cycleString}.");
        }

        return new self(
            array_map(
                fn (array $match): CycleTypeWithCount => new CycleTypeWithCount(new CycleType($match[1]), (int) $match[2]),
                $matches
            ),
            $indexOrientation
        );
    }

    public function fillUpTo(int $fillUpToMaxNucleotideCount, NucleotideType $nucleotideType): self
    {
        $countOfAllCycleTypes = $this->sumCountOfAllCycles();
        if ($countOfAllCycleTypes > $fillUpToMaxNucleotideCount) {
            throw new IlluminaSampleSheetException("The sum of all cycle types must be less than or equal to the fill up to max value. \$countOfAllCycleTypes: {$countOfAllCycleTypes} > \$fillUpToMax: {$fillUpToMaxNucleotideCount}");
        }

        if ($countOfAllCycleTypes === $fillUpToMaxNucleotideCount) {
            return $this;
        }

        $trimmedCycle = new CycleTypeWithCount(
            new CycleType(CycleType::TRIMMED_CYCLE),
            $fillUpToMaxNucleotideCount - $countOfAllCycleTypes
        );

        $newCycleTypeWithCountList = $this->cycleTypeWithCountList;

        if ($nucleotideType->value === NucleotideType::I2 && $this->indexOrientation->value === IndexOrientation::FORWARD) {
            array_unshift($newCycleTypeWithCountList, $trimmedCycle);
        } else {
            $newCycleTypeWithCountList[] = $trimmedCycle;
        }

        return new self($newCycleTypeWithCountList, $this->indexOrientation);
    }

    public function sumCountOfAllCycles(): int
    {
        return array_sum(
            array_map(
                fn (CycleTypeWithCount $cycleTypeWithCount): int => $cycleTypeWithCount->count,
                $this->cycleTypeWithCountList
            )
        );
    }

    public function toString(): string
    {
        return implode('', array_map(
            fn (CycleTypeWithCount $cycle): string => $cycle->toString(),
            $this->cycleTypeWithCountList
        ));
    }
}

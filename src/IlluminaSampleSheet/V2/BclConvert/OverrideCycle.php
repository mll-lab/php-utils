<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;

class OverrideCycle
{
    public NucleotideType $nucleotideType;

    /** @var array<int, CycleTypeWithCount> */
    public array $cycleTypeWithCountList;

    public IndexOrientation $indexOrientation;

    /** @param array<int, CycleTypeWithCount> $cycleTypeWithCountList */
    public function __construct(NucleotideType $nucleotideType, array $cycleTypeWithCountList, IndexOrientation $indexOrientation)
    {
        $this->nucleotideType = $nucleotideType;
        $this->cycleTypeWithCountList = $cycleTypeWithCountList;
        $this->indexOrientation = $indexOrientation;
    }

    public static function fromString(
        string $nucleotideAndCycleString,
        IndexOrientation $indexOrientation
    ): self {
        [$nucleotideTypeAsString, $cycleString] = explode(':', $nucleotideAndCycleString);
        \Safe\preg_match_all('/([YNUI]+)(\d+)/', $cycleString, $matches, PREG_SET_ORDER);

        if (count($matches) > 4) {
            throw new IlluminaSampleSheetException("Invalid Override Cycle Part. Should have less than 4 parts: {$cycleString}.");
        }

        if (count($matches) === 0) {
            throw new IlluminaSampleSheetException("Invalid Override Cycle Part. Should have at least 1 part: {$cycleString}.");
        }

        $nucleotideType = NucleotideType::from($nucleotideTypeAsString);

        return new self(
            $nucleotideType,
            array_map(
                fn (array $match): CycleTypeWithCount => new CycleTypeWithCount(CycleType::from($match[1]), (int) $match[2]),
                $matches
            ),
            $indexOrientation
        );
    }

    public function fillUpTo(int $fillUpToMaxNucleotideCount): self
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

        if ($this->nucleotideType->value === NucleotideType::I2 && $this->indexOrientation->value === IndexOrientation::FORWARD) {
            array_unshift($this->cycleTypeWithCountList, $trimmedCycle);
        } else {
            $this->cycleTypeWithCountList[] = $trimmedCycle;
        }

        return $this;
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
        return
            "{$this->nucleotideType->value}:"
            . implode('', array_map(
                fn (CycleTypeWithCount $cycle): string => $cycle->toString(),
                $this->cycleTypeWithCountList
            ));
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;

class OverrideCycles
{
    public OverrideCycle $read1;

    public OverrideCycle $index1;

    public ?OverrideCycle $index2;

    public ?OverrideCycle $read2;

    public function __construct(string $read1, string $index1, ?string $index2, ?string $read2)
    {
        $this->read1 = $this->makeOverrideCycle($read1);
        $this->index1 = $this->makeOverrideCycle($index1);
        $this->index2 = $index2 !== null ? $this->makeOverrideCycle($index2) : null;
        $this->read2 = $read2 !== null ? $this->makeOverrideCycle($read2) : null;
    }

    public function toString(): string
    {
        return implode(';', array_filter([
            $this->read1->toString(),
            $this->index1->toString(),
            $this->index2 instanceof OverrideCycle
                ? $this->index2->toString()
                : null,
            $this->read2 instanceof OverrideCycle
                ? $this->read2->toString()
                : null,
        ]));
    }

    public function makeOverrideCycle(string $cycleString): OverrideCycle
    {
        \Safe\preg_match_all('/([YNUI]+)(\d+)/', $cycleString, $matches, PREG_SET_ORDER);

        if (count($matches) > 3) {
            throw new IlluminaSampleSheetException("Invalid Override Cycle Part. Should have less than 4 parts: {$cycleString}.");
        }

        if (count($matches) === 0) {
            throw new IlluminaSampleSheetException("Invalid Override Cycle Part. Should have at least 1 part: {$cycleString}.");
        }

        return new OverrideCycle(
            array_map(
                fn (array $match) => new CycleTypeWithCount(new CycleType($match[1]), (int) $match[2]),
                $matches
            )
        );
    }
}

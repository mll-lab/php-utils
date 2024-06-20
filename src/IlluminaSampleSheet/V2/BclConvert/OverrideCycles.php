<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V2\HeaderSection;

class OverrideCycles
{
    public OverrideCycle $read1;

    public OverrideCycle $index1;

    public ?OverrideCycle $index2;

    public ?OverrideCycle $read2;

    private DataSection $dataSection;

    public function __construct(DataSection $dataSection, string $read1, string $index1, ?string $index2, ?string $read2)
    {
        $this->read1 = $this->makeOverrideCycle($read1);
        $this->index1 = $this->makeOverrideCycle($index1);
        $this->index2 = $index2 !== null ? $this->makeOverrideCycle($index2) : null;
        $this->read2 = $read2 !== null ? $this->makeOverrideCycle($read2) : null;
        $this->dataSection = $dataSection;
    }

    public function toString(): string
    {
        $dataSection = $this->dataSection;
        $dataSection->assertNotEmpty();

        return implode(';', array_filter([
            $this->read1->toString($dataSection->maxRead1Cycles(), null),
            $this->index1->toString($dataSection->maxIndex1Cycles(), null),
            $this->index2(),
            $this->read2(),
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

    private function index2(): ?string
    {
        if (! $this->index2 instanceof OverrideCycle) {
            return null;
        }
        $maxIndex2Cycles = $this->dataSection->maxIndex2Cycles();
        if ($maxIndex2Cycles === null) {
            throw new IlluminaSampleSheetException('MaxIndex2Cycles is required when Index2 is set.');
        }

        return $this->index2->toString($maxIndex2Cycles, HeaderSection::isForwardIndexOrientation());
    }

    private function read2(): ?string
    {
        if (! $this->read2 instanceof OverrideCycle) {
            return null;
        }
        $maxIndex2Cycles = $this->dataSection->maxRead2Cycles();
        if ($maxIndex2Cycles === null) {
            throw new IlluminaSampleSheetException('MaxRead2Cycles is required when Read2 is set.');
        }

        return $this->read2->toString($maxIndex2Cycles, null);
    }
}

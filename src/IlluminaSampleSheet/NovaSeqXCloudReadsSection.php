<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class NovaSeqXCloudReadsSection implements SectionInterface
{
    public int $read1Cycles;

    public int $read2Cycles;

    public int $index1Cycles;

    public int $index2Cycles;

    public function __construct(
        int $read1Cycles,
        int $read2Cycles,
        int $index1Cycles,
        int $index2Cycles
    ) {
        $this->read1Cycles = $read1Cycles;
        $this->read2Cycles = $read2Cycles;
        $this->index1Cycles = $index1Cycles;
        $this->index2Cycles = $index2Cycles;
    }

    public function toString(): string
    {
        $readsLines = [
            '[Reads]',
            "Read1Cycles,{$this->read1Cycles}",
            "Read2Cycles,{$this->read2Cycles}",
            "Index1Cycles,{$this->index1Cycles}",
            "Index2Cycles,{$this->index2Cycles}",
            '',
        ];

        return implode("\n", $readsLines);
    }
}

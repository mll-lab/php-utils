<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class ReadsSection implements SectionInterface
{
    private int $read1Cycles;

    private int $read2Cycles;

    public function __construct(int $read1Cycles, int $read2Cycles)
    {
        $this->read1Cycles = $read1Cycles;
        $this->read2Cycles = $read2Cycles;
    }

    public function convertSectionToString(): string
    {
        return "[Reads]\n" . $this->read1Cycles . "\n" . $this->read2Cycles;
    }
}

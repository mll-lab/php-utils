<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\Section;

class ReadsSection implements Section
{
    public function __construct(
        private readonly int $read1Cycles,
        private readonly int $read2Cycles
    ) {}

    public function convertSectionToString(): string
    {
        return "[Reads]\n" . $this->read1Cycles . "\n" . $this->read2Cycles;
    }
}

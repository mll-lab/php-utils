<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;

class ReadsSection implements Section
{
    protected int $read1Cycles;

    protected ?int $read2Cycles;

    protected ?int $index1Cycles;

    protected ?int $index2Cycles;

    public function __construct(int $read1Cycles, ?int $read2Cycles = null, ?int $index1Cycles = null, ?int $index2Cycles = null)
    {
        if ($read1Cycles < 1) {
            throw new IlluminaSampleSheetException('Read1Cycles must be a positive integer.');
        }
        if ($read2Cycles !== null && $read2Cycles < 1) {
            throw new IlluminaSampleSheetException('Read2Cycles must be a positive integer or null.');
        }
        if ($index1Cycles !== null && ($index1Cycles < 6 || $index1Cycles > 12)) {
            throw new IlluminaSampleSheetException('Index1Cycles must be between 6 and 12 or null.');
        }
        if ($index2Cycles !== null && ($index2Cycles < 6 || $index2Cycles > 12)) {
            throw new IlluminaSampleSheetException('Index2Cycles must be between 6 and 12 or null.');
        }
        $this->read1Cycles = $read1Cycles;
        $this->read2Cycles = $read2Cycles;
        $this->index1Cycles = $index1Cycles;
        $this->index2Cycles = $index2Cycles;
    }

    public function convertSectionToString(): string
    {
        $readsLines = ['[Reads]'];
        $readsLines[] = "Read1Cycles,{$this->read1Cycles}";

        if ($this->read2Cycles !== null) {
            $readsLines[] = "Read2Cycles,{$this->read2Cycles}";
        }
        if ($this->index1Cycles !== null) {
            $readsLines[] = "Index1Cycles,{$this->index1Cycles}";
        }
        if ($this->index2Cycles !== null) {
            $readsLines[] = "Index2Cycles,{$this->index2Cycles}";
        }

        return implode("\n", $readsLines) . "\n";
    }
}

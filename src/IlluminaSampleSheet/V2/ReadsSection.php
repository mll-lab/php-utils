<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;

class ReadsSection implements Section
{
    private int $read1Cycles;

    private ?int $read2Cycles;

    private ?int $index1Cycles;

    private ?int $index2Cycles;

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

        if (isset($this->read1Cycles)) {
            $readsLines[] = "Read1Cycles,{$this->read1Cycles}";
        }
        if (isset($this->read2Cycles)) {
            $readsLines[] = "Read2Cycles,{$this->read2Cycles}";
        }
        if (isset($this->index1Cycles)) {
            $readsLines[] = "Index1Cycles,{$this->index1Cycles}";
        }
        if (isset($this->index2Cycles)) {
            $readsLines[] = "Index2Cycles,{$this->index2Cycles}";
        }

        return implode("\n", $readsLines) . "\n";
    }
}

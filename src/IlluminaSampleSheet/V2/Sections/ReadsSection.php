<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycleCounter;

class ReadsSection extends SimpleKeyValueSection
{
    public function __construct(
        int $read1CycleCount,
        int $index1CycleCount,
        ?int $read2CycleCount,
        ?int $index2CycleCount
    ) {
        if ($read1CycleCount < 1) {
            throw new IlluminaSampleSheetException('Read1Cycles must be a positive integer.');
        }
        if ($read2CycleCount !== null && $read2CycleCount < 1) {
            throw new IlluminaSampleSheetException('Read2Cycles must be a positive integer or null.');
        }
        if ($index1CycleCount < 6) {
            throw new IlluminaSampleSheetException('Index1Cycles must be at least 6.');
        }
        if ($index2CycleCount !== null && ($index2CycleCount < 6)) {
            throw new IlluminaSampleSheetException('Index2Cycles must be at least 6.');
        }

        $fields = new Collection();

        $fields->put('Read1Cycles', $read1CycleCount);
        if (is_int($read2CycleCount)) {
            $fields->put('Read2Cycles', $read2CycleCount);
        }

        $fields->put('Index1Cycles', $index1CycleCount);
        if (is_int($index2CycleCount)) {
            $fields->put('Index2Cycles', $index2CycleCount);
        }

        parent::__construct($fields);
    }

    public static function fromOverrideCycleCounter(OverrideCycleCounter $overrideCycleCounter): self
    {
        return new self(
            read1CycleCount: $overrideCycleCounter->maxRead1CycleCount(),
            index1CycleCount: $overrideCycleCounter->maxIndex1CycleCount(),
            read2CycleCount: $overrideCycleCounter->maxRead2CycleCount(),
            index2CycleCount: $overrideCycleCounter->maxIndex2CycleCount()
        );
    }

    public function sectionName(): string
    {
        return 'Reads';
    }
}

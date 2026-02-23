<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycleCounter;

class ReadsSection extends SimpleKeyValueSection
{
    public function __construct(
        int $maximumCycleCountForRead1,
        int $maximumCycleCountForIndex1,
        int $maximumCycleCountForRead2,
        int $maximumCycleCountForIndex2
    ) {
        if ($maximumCycleCountForRead1 < 1) {
            throw new IlluminaSampleSheetException('Read1Cycles must be a positive integer.');
        }
        /**
         * Maximum cycle count for read 2 can be 0 (Single Read sequencing mode), but it the maximum cycle count for
         * read 2 exists (Paired read sequencing mode) it has to be at least 6
         */
        if (
            $maximumCycleCountForRead2 < 0
            || ($maximumCycleCountForRead2 > 0 && $maximumCycleCountForRead2 < 6)
        ){
            throw new IlluminaSampleSheetException('Read2Cycles must be a positive integer.');
        }

        if ($maximumCycleCountForIndex1 < 6){
            throw new IlluminaSampleSheetException('Index1Cycles must be at least 6.');
        }
        /**
         * Maximum cycle count for index2 can be 0 (Single Indexing), but it the maximum cycle count for index 2
         * exists (Dual indexing) it has to be at least 6
         */
        if (
            $maximumCycleCountForIndex2 < 0
            || ($maximumCycleCountForIndex2 > 0 && $maximumCycleCountForIndex2 < 6)
        ){
            throw new IlluminaSampleSheetException('Index2Cycles must be at least 6.');
        }

        $fields = new Collection();

        $fields->put('Read1Cycles', $maximumCycleCountForRead1);
        if ($maximumCycleCountForRead2 > 0) {
            $fields->put('Read2Cycles', $maximumCycleCountForRead2);
        }

        $fields->put('Index1Cycles', $maximumCycleCountForIndex1);
        if ($maximumCycleCountForIndex2 > 0) {
            $fields->put('Index2Cycles', $maximumCycleCountForIndex2);
        }

        parent::__construct($fields);
    }

    public static function fromOverrideCycleCounter(OverrideCycleCounter $overrideCycleCounter): self
    {
        return new self(
            $overrideCycleCounter->maxRead1CycleCount(),
            $overrideCycleCounter->maxIndex1CycleCount(),
            $overrideCycleCounter->maxRead2CycleCount(),
            $overrideCycleCounter->maxIndex2CycleCount()
        );
    }

    public function sectionName(): string
    {
        return 'Reads';
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclSample;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycleCounter;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycles;

class BclConvertDataSection implements Section
{
    /** @var Collection<int, BclSample> */
    public Collection $bclSampleList;

    public OverrideCycleCounter $overrideCycleCounter;

    /** @param Collection<int, BclSample> $bclSampleList */
    public function __construct(Collection $bclSampleList)
    {
        $this->bclSampleList = $bclSampleList;
        $this->overrideCycleCounter = new OverrideCycleCounter(
            $this->bclSampleList->map(fn (BclSample $bclSample): OverrideCycles => $bclSample->overrideCycles)
        );
    }

    public function convertSectionToString(): string
    {
        $this->assertNotEmpty();
        $this->assertConsistentBarcodeMismatchesIndex2();

        $includeBarcodeMismatchesIndex2 = $this->hasBarcodeMismatchesIndex2();

        return
            self::headerRow($includeBarcodeMismatchesIndex2) . PHP_EOL
            . $this->bclSampleList
                ->map(fn (BclSample $bclSample): string => $bclSample->toString($this->overrideCycleCounter, $includeBarcodeMismatchesIndex2))
                ->join(PHP_EOL) . PHP_EOL;
    }

    private function hasBarcodeMismatchesIndex2(): bool
    {
        return $this->bclSampleList->contains(fn (BclSample $bclSample): bool => $bclSample->barcodeMismatchesIndex2 !== null);
    }

    private function assertConsistentBarcodeMismatchesIndex2(): void
    {
        $withIndex2 = $this->bclSampleList->contains(fn (BclSample $bclSample): bool => $bclSample->barcodeMismatchesIndex2 !== null);
        $withoutIndex2 = $this->bclSampleList->contains(fn (BclSample $bclSample): bool => $bclSample->barcodeMismatchesIndex2 === null);

        if ($withIndex2 && $withoutIndex2) {
            throw new IlluminaSampleSheetException('Either all or no samples must have a barcodeMismatchesIndex2.');
        }
    }

    private static function headerRow(bool $includeBarcodeMismatchesIndex2): string
    {
        $columns = [
            'Lane',
            'Sample_ID',
            'Index',
            'Index2',
            'OverrideCycles',
            'AdapterRead1',
            'AdapterRead2',
            'BarcodeMismatchesIndex1',
        ];

        if ($includeBarcodeMismatchesIndex2) {
            $columns[] = 'BarcodeMismatchesIndex2';
        }

        return implode(',', $columns);
    }

    public function assertNotEmpty(): void
    {
        if ($this->bclSampleList->isEmpty()) {
            throw new IlluminaSampleSheetException('At least one sample must be added to the DataSection.');
        }
    }

    public function sectionName(): string
    {
        return 'BCLConvert_Data';
    }
}

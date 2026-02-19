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
    public $bclSampleList;

    /** @var OverrideCycleCounter */
    public $overrideCycleCounter;

    /**
     * @param Collection<int, BclSample> $bclSampleList
     */
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

        return
            BclSample::HEADER_ROW . PHP_EOL .
            $this->bclSampleList
            ->map(fn (BclSample $bclSample): string => $bclSample->toString($this->overrideCycleCounter))
            ->join(PHP_EOL) . PHP_EOL;
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

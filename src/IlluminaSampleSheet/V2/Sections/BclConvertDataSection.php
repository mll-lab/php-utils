<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclSample;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycleCounter;

class BclConvertDataSection implements Section
{
    /**
     * @param Collection<int, BclSample> $dataRows
     */
    public function __construct(public Collection $dataRows, public OverrideCycleCounter $overrideCycleCounter)
    {}

    public function convertSectionToString(): string
    {
        $this->assertNotEmpty();

        return
            BclSample::HEADER_ROW . PHP_EOL .
            $this->dataRows
            ->map(fn (BclSample $bclSample): string => $bclSample->toString($this->overrideCycleCounter))
            ->join(PHP_EOL) . PHP_EOL;
    }

    public function assertNotEmpty(): void
    {
        if ($this->dataRows->isEmpty()) {
            throw new IlluminaSampleSheetException('At least one sample must be added to the DataSection.');
        }
    }

    public function sectionName(): string
    {
        return 'BCLConvert_Data';
    }
}

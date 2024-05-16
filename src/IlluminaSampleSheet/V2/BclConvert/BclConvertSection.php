<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\Section;
use MLL\Utils\IlluminaSampleSheet\V2\ReadsSection;

class BclConvertSection implements Section
{
    protected SettingsSection $settingsSection;

    protected DataSection $dataSection;

    public function __construct(SettingsSection $settingsSection, DataSection $dataSection)
    {
        $this->settingsSection = $settingsSection;
        $this->dataSection = $dataSection;
    }

    public function convertSectionToString(): string
    {
        $bclConvertLines = [
            $this->settingsSection->convertSectionToString(),
            $this->dataSection->convertSectionToString(),
        ];

        return implode("\n", $bclConvertLines);
    }

    public function makeReadsSection(): ReadsSection
    {
        $dataRows = new Collection($this->dataSection->dataRows);

        $countFromCycleTypeWithCount = fn (CycleTypeWithCount $cycleTypeWithCount) => $cycleTypeWithCount->count;

        $read1Cycles = $dataRows->max(
            fn (BclSample $dataRow) => (new Collection($dataRow->overrideCycles->read1->cycles)
            )->sum($countFromCycleTypeWithCount)
        );
        $index1Cycles = $dataRows->max(
            fn (BclSample $dataRow) => (new Collection($dataRow->overrideCycles->index1->cycles)
            )->sum($countFromCycleTypeWithCount)
        );

        $index2Cycles = $dataRows->max(
            fn (BclSample $dataRow) => $dataRow->overrideCycles->index2 instanceof OverrideCycle
                ? (new Collection($dataRow->overrideCycles->index2->cycles))
                    ->sum($countFromCycleTypeWithCount)
                : null
        );
        $read2Cycles = $dataRows->max(
            fn (BclSample $dataRow) => $dataRow->overrideCycles->read2 instanceof OverrideCycle
                ? (new Collection($dataRow->overrideCycles->read2->cycles))
                    ->sum($countFromCycleTypeWithCount)
                : null
        );

        assert(is_int($read1Cycles));
        assert(is_int($index1Cycles));
        assert(is_int($read2Cycles) || is_null($read2Cycles));
        assert(is_int($index2Cycles) || is_null($index2Cycles));

        return new ReadsSection($read1Cycles, $index1Cycles, $read2Cycles, $index2Cycles);
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;
use MLL\Utils\IlluminaSampleSheet\V2\ReadsSection;

class DataSection implements Section
{
    /** @var Collection<int, BclSample> */
    public Collection $dataRows;

    public function __construct()
    {
        $this->dataRows = new Collection();
    }

    public function addSample(BclSample $bclSample): void
    {
        $this->dataRows->add($bclSample);
    }

    public function convertSectionToString(): string
    {
        if ($this->dataRows->isEmpty()) {
            throw new IlluminaSampleSheetException('At least one sample must be added to the DataSection.');
        }

        /** @var array<string> $samplePropertiesOfFirstSample */
        $samplePropertiesOfFirstSample = array_keys(get_object_vars($this->dataRows[0]));
        foreach ($this->dataRows as $sample) {
            $actualProperties = array_keys(get_object_vars($sample));
            if ($samplePropertiesOfFirstSample !== $actualProperties) {
                throw new IlluminaSampleSheetException('All samples must have the same properties. Expected: ' . \Safe\json_encode($samplePropertiesOfFirstSample) . ', Actual: ' . \Safe\json_encode($actualProperties));
            }
        }

        $bclConvertDataHeaderLines = $this->generateDataHeaderByProperties($samplePropertiesOfFirstSample);

        $bclConvertDataLines = [
            '[BCLConvert_Data]',
            $bclConvertDataHeaderLines,
        ];

        foreach ($this->dataRows as $dataRow) {
            $bclConvertDataLines[] = implode(',', $dataRow->toArray());
        }

        return implode("\n", $bclConvertDataLines) . "\n";
    }

    /** @param array<string> $samplePropertiesOfFirstSample */
    protected function generateDataHeaderByProperties(array $samplePropertiesOfFirstSample): string
    {
        $samplePropertiesOfFirstSample = array_filter($samplePropertiesOfFirstSample, fn (string $value) // @phpstan-ignore-next-line Variable property access on a non-object required here
        => $this->dataRows[0]->$value !== null);

        $samplePropertiesOfFirstSample = array_map(fn (string $value) => ucfirst($value), $samplePropertiesOfFirstSample);

        return implode(',', $samplePropertiesOfFirstSample);
    }

    public function makeReadsSection(): ReadsSection
    {
        return new ReadsSection(
            $this->maxRead1Cycles(),
            $this->maxIndex1Cycles(),
            $this->maxRead2Cycles(),
            $this->maxIndex2Cycles()
        );
    }

    public function maxRead1Cycles(): int
    {
        $max = $this->dataRows
            ->max(fn (BclSample $dataRow): int => $dataRow
                ->overrideCycles
                ->read1
                ->sumCountOfAllCycles());
        assert(is_int($max));

        return $max;
    }

    public function maxRead2Cycles(): ?int
    {
        $max = $this->dataRows->max(
            fn (BclSample $dataRow): ?int => $dataRow->overrideCycles->read2 instanceof OverrideCycle
                ? $dataRow->overrideCycles->read2->sumCountOfAllCycles()
                : null
        );
        assert(is_int($max) || is_null($max));

        return $max;
    }

    public function maxIndex1Cycles(): int
    {
        $index1Cycles = $this->dataRows
            ->max(fn (BclSample $dataRow): int => $dataRow
                ->overrideCycles
                ->index1
                ->sumCountOfAllCycles());
        assert(is_int($index1Cycles));

        return $index1Cycles;
    }

    public function maxIndex2Cycles(): ?int
    {
        $index2Cycles = $this->dataRows->max(
            fn (BclSample $dataRow): ?int => $dataRow->overrideCycles->index2 instanceof OverrideCycle
                ? $dataRow->overrideCycles->index2->sumCountOfAllCycles()
                : null
        );
        assert(is_int($index2Cycles) || is_null($index2Cycles));

        return $index2Cycles;
    }
}

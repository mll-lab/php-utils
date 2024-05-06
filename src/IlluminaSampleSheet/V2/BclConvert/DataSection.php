<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\Section;

class DataSection implements Section
{
    /** @var array<BclSample> */
    protected array $dataRows = [];

    public function addSample(BclSample $bclSample): void
    {
        $this->dataRows[] = $bclSample;
    }

    public function convertSectionToString(): string
    {
        /** @var array<string> $samplePropertiesOfFirstSample */
        $samplePropertiesOfFirstSample = array_keys(get_object_vars($this->dataRows[0]));
        foreach ($this->dataRows as $sample) {
            $actualProperties = array_keys(get_object_vars($sample));
            if ($samplePropertiesOfFirstSample !== $actualProperties) {
                throw new \Exception('All samples must have the same properties. Expected: ' . \Safe\json_encode($samplePropertiesOfFirstSample) . ', Actual: ' . \Safe\json_encode($actualProperties));
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
}

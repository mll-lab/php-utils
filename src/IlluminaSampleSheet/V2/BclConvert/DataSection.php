<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class DataSection implements SectionInterface
{
    /** @var array<BclSample> */
    private array $dataRows = [];

    public function addSample(
        BclSample $bclSample
    ): void {
        $this->dataRows[] = $bclSample;
    }

    public function convertSectionToString(): string
    {
        /** @var array<string> $samplePropertiesOfFirstSample */
        $samplePropertiesOfFirstSample = array_keys(get_object_vars($this->dataRows[0]));
        foreach ($this->dataRows as $sample) {
            if ($samplePropertiesOfFirstSample !== array_keys(get_object_vars($sample))) {
                throw new \Exception('All samples must have the same properties');
            }
        }

        $bclConvertDataLines = $this->generateDataHeaderByProperites($samplePropertiesOfFirstSample);

        $bclConvertDataLines = [
            '[BCLConvert_Data]',
            $bclConvertDataLines,
        ];

        foreach ($this->dataRows as $dataRow) {
            $bclConvertDataLines[] = implode(',', $dataRow->toArray());
        }

        return implode("\n", $bclConvertDataLines) . "\n";
    }

    /** @param array<string> $samplePropertiesOfFirstSample */
    private function generateDataHeaderByProperites(array $samplePropertiesOfFirstSample): string
    {
        $samplePropertiesOfFirstSample = array_filter($samplePropertiesOfFirstSample, fn ($value) // @phpstan-ignore-next-line Variable property access on a non-object required here
        => $this->dataRows[0]->$value !== null);

        $samplePropertiesOfFirstSample = array_map(fn ($value) => ucfirst($value), $samplePropertiesOfFirstSample);

        return implode(',', $samplePropertiesOfFirstSample);
    }
}

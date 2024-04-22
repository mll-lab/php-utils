<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class BclConvertDataSection implements SectionInterface
{
    /** @var array<BclConvertDataRow> */
    private array $dataRows = [];

    public function addSample(
        int $lane,
        string $sampleId,
        string $index,
        string $index2,
        string $overrideCycles,
        string $adapterRead1,
        string $adapterRead2
    ): void {
        $this->dataRows[] = new BclConvertDataRow(
            $lane,
            $sampleId,
            $index,
            $index2,
            $overrideCycles,
            $adapterRead1,
            $adapterRead2
        );
    }

    public function toString(): string
    {
        $bclConvertDataLines = [
            '[BCLConvert_Data]',
            'Lane,Sample_ID,Index,Index2,OverrideCycles,AdapterRead1,AdapterRead2',
        ];

        foreach ($this->dataRows as $dataRow) {
            $bclConvertDataLines[] = implode(',', $dataRow->toArray());
        }

        return implode("\n", $bclConvertDataLines) . "\n";
    }
}

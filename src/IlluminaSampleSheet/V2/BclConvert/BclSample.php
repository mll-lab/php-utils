<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class BclSample
{
    public int $lane;

    // Keep the name "$sample_ID" as it is, because the property-name is used to generate the csv header line for the BCL-Sample-Section
    public string $sample_ID;

    public string $index;

    public ?string $index2 = null;

    public ?string $overrideCycles = null;

    public ?string $adapterRead1 = null;

    public ?string $adapterRead2 = null;

    public ?string $barcodeMismatchesIndex1 = null;

    public ?string $barcodeMismatchesIndex2 = null;

    public function __construct(
        int $lane,
        string $sample_ID,
        string $index
    ) {
        $this->lane = $lane;
        $this->sample_ID = $sample_ID;
        $this->index = $index;
    }

    /** @return array<int|string> */
    public function toArray(): array
    {
        return array_filter([
            $this->lane,
            $this->sample_ID,
            $this->index,
            $this->index2,
            $this->overrideCycles,
            $this->adapterRead1,
            $this->adapterRead2,
            $this->barcodeMismatchesIndex1,
            $this->barcodeMismatchesIndex2,
        ]);
    }
}

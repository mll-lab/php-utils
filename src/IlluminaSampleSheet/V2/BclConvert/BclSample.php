<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class BclSample
{
    public int $lane;

    /** Not using camelCase because the property names of this class must match the CSV file. */
    public string $sample_ID;

    public string $index;

    public ?string $index2 = null;

    public OverrideCycles $overrideCycles;

    public ?string $adapterRead1 = null;

    public ?string $adapterRead2 = null;

    public ?string $barcodeMismatchesIndex1 = null;

    public ?string $barcodeMismatchesIndex2 = null;

    public ?string $project = null;

    public function __construct(
        int $lane,
        string $sample_ID,
        string $index,
        OverrideCycles $overrideCycles
    ) {
        $this->lane = $lane;
        $this->sample_ID = $sample_ID;
        $this->index = $index;
        $this->overrideCycles = $overrideCycles;
    }

    /** @return array<int|string> */
    public function toArray(): array
    {
        return array_filter([ // @phpstan-ignore arrayFilter.strict (we want truthy comparison)
            $this->lane,
            $this->sample_ID,
            $this->index,
            $this->index2,
            $this->overrideCycles->toString(),
            $this->adapterRead1,
            $this->adapterRead2,
            $this->barcodeMismatchesIndex1,
            $this->barcodeMismatchesIndex2,
            $this->project,
        ]);
    }
}

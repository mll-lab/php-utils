<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class BclConvertDataRow
{
    public int $lane;

    public string $sampleId;

    public string $index;

    public string $index2;

    public string $overrideCycles;

    public string $adapterRead1;

    public string $adapterRead2;

    public function __construct(
        int $lane,
        string $sampleId,
        string $index,
        string $index2,
        string $overrideCycles,
        string $adapterRead1,
        string $adapterRead2
    ) {
        $this->lane = $lane;
        $this->sampleId = $sampleId;
        $this->index = $index;
        $this->index2 = $index2;
        $this->overrideCycles = $overrideCycles;
        $this->adapterRead1 = $adapterRead1;
        $this->adapterRead2 = $adapterRead2;
    }

    /** @return array<int, int|string> */
    public function toArray(): array
    {
        return [
            $this->lane,
            $this->sampleId,
            $this->index,
            $this->index2,
            $this->overrideCycles,
            $this->adapterRead1,
            $this->adapterRead2,
        ];
    }
}

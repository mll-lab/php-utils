<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class BclSample
{
    public int $lane;

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
        string $sampleID,
        string $index
    ) {
        $this->lane = $lane;
        $this->sample_ID = $sampleID;
        $this->index = $index;
    }

    public function setIndex2(string $index2): BclSample
    {
        $this->index2 = $index2;

        return $this;
    }

    public function setOverrideCycles(string $overrideCycles): BclSample
    {
        $this->overrideCycles = $overrideCycles;

        return $this;
    }

    public function setAdapterRead1(string $adapterRead1): BclSample
    {
        $this->adapterRead1 = $adapterRead1;

        return $this;
    }

    public function setAdapterRead2(string $adapterRead2): BclSample
    {
        $this->adapterRead2 = $adapterRead2;

        return $this;
    }

    public function setBarcodeMismatchesIndex1(string $barcodeMismatchesIndex1): BclSample
    {
        $this->barcodeMismatchesIndex1 = $barcodeMismatchesIndex1;

        return $this;
    }

    public function setBarcodeMismatchesIndex2(string $barcodeMismatchesIndex2): BclSample
    {
        $this->barcodeMismatchesIndex2 = $barcodeMismatchesIndex2;

        return $this;
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

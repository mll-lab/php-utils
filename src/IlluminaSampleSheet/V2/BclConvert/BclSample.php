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
        string $sampleId,
        string $index
    ) {
        $this->lane = $lane;
        $this->sample_ID = $sampleId;
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
        $data = [
            $this->lane,
            $this->sample_ID,
            $this->index,
        ];

        if (! is_null($this->index2)) {
            $data[] = $this->index2;
        }

        if (! is_null($this->overrideCycles)) {
            $data[] = $this->overrideCycles;
        }

        if (! is_null($this->adapterRead1)) {
            $data[] = $this->adapterRead1;
        }

        if (! is_null($this->adapterRead2)) {
            $data[] = $this->adapterRead2;
        }

        if (! is_null($this->barcodeMismatchesIndex1)) {
            $data[] = $this->barcodeMismatchesIndex1;
        }

        if (! is_null($this->barcodeMismatchesIndex2)) {
            $data[] = $this->barcodeMismatchesIndex2;
        }

        return $data;
    }
}

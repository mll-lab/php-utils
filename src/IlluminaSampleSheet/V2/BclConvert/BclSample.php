<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\Flowcells\FlowcellType;

class BclSample
{
    public FlowcellType $flowcellType;

    public string $sampleID;

    public string $indexRead1;

    public ?string $indexRead2;

    public OverrideCycles $overrideCycles;

    public string $adapterRead1;

    public string $adapterRead2;

    public string $barcodeMismatchesIndex1;

    public ?string $barcodeMismatchesIndex2;

    public function __construct(
        FlowcellType $flowcellType,
        string $sampleID,
        string $indexRead1,
        ?string $indexRead2,
        OverrideCycles $overrideCycles,
        string $adapterRead1,
        string $adapterRead2,
        string $barcodeMismatchesIndex1,
        ?string $barcodeMismatchesIndex2
    ) {
        $this->flowcellType = $flowcellType;
        $this->sampleID = $sampleID;
        $this->indexRead1 = $indexRead1;
        $this->indexRead2 = $indexRead2;
        $this->overrideCycles = $overrideCycles;
        $this->adapterRead1 = $adapterRead1;
        $this->adapterRead2 = $adapterRead2;
        $this->barcodeMismatchesIndex1 = $barcodeMismatchesIndex1;
        $this->barcodeMismatchesIndex2 = $barcodeMismatchesIndex2;
    }

    public function toString(OverrideCycleCounter $overrideCycleCounter): string
    {
        $lines = array_map(
            fn (int $lane): string => implode(',', [
                $lane,
                $this->sampleID,
                $this->indexRead1,
                $this->indexRead2 ?? '',
                $this->overrideCycles->toString($overrideCycleCounter),
                $this->adapterRead1,
                $this->adapterRead2,
                $this->barcodeMismatchesIndex1,
                $this->barcodeMismatchesIndex2 ?? '',
            ]),
            $this->flowcellType->lanes
        );

        return implode(PHP_EOL, $lines);
    }
}

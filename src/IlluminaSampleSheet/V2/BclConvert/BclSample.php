<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class BclSample
{
    /** @var string */
    public const HEADER_ROW = 'Lane,Sample_ID,Index,Index2,OverrideCycles,AdapterRead1,AdapterRead2,BarcodeMismatchesIndex1,BarcodeMismatchesIndex2';

    /** @var FlowcellType */
    public $flowcellType;

    /** @var string */
    public $sampleID;

    /** @var string */
    public $indexRead1;

    /** @var string */
    public $indexRead2;

    /** @var OverrideCycles */
    public $overrideCycles;

    /** @var string */
    public $adapterRead1;

    /** @var string */
    public $adapterRead2;

    /** @var string */
    public $barcodeMismatchesIndex1;

    /** @var string */
    public $barcodeMismatchesIndex2;

    public function __construct(
        FlowcellType $flowcellType,
        string $sampleID,
        string $indexRead1,
        string $indexRead2,
        OverrideCycles $overrideCycles,
        string $adapterRead1,
        string $adapterRead2,
        string $barcodeMismatchesIndex1,
        string $barcodeMismatchesIndex2
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
        $content = [];
        foreach ($this->flowcellType->lanes as $lane) {
            $content[] = join(
                ',',
                [
                    $lane,
                    $this->sampleID,
                    $this->indexRead1,
                    $this->indexRead2,
                    $this->overrideCycles->toString($overrideCycleCounter),
                    $this->adapterRead1,
                    $this->adapterRead2,
                    $this->barcodeMismatchesIndex1,
                    $this->barcodeMismatchesIndex2,
                ]
            );
        }
        return implode(PHP_EOL, $content);
    }
}

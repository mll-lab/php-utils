<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class BclSample
{
    /** @var string  */
    public const HEADER_ROW = 'Lane,Sample_ID,Index,Index2,OverrideCycles,AdapterRead1,AdapterRead2,BarcodeMismatchesIndex1,BarcodeMismatchesIndex2';

    /**
     * @param array<int, int> $lanes
     * @param string $sampleID
     * @param string $indexRead1
     * @param string $indexRead2
     * @param OverrideCycles $overrideCycles
     * @param string $adapterRead1
     * @param string $adapterRead2
     * @param string $barcodeMismatchesIndex1
     * @param string $barcodeMismatchesIndex2
     */
    public function __construct(
        public array          $lanes,
        public string         $sampleID,
        public string         $indexRead1,
        public string         $indexRead2,
        public OverrideCycles $overrideCycles,
        public string         $adapterRead1,
        public string         $adapterRead2,
        public string         $barcodeMismatchesIndex1,
        public string         $barcodeMismatchesIndex2,
    ) {}

    public function toString(OverrideCycleCounter $overrideCycleCounter): string
    {
        $content = [];
        foreach($this->lanes as $lane) {
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

<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

class SampleDTO
{
    public string $sampleName;

    public string $type;

    public string $target;

    public function __construct(string $labID, string $type, string $target)
    {
        $this->sampleName = $labID;
        $this->type = $type;
        $this->target = $target;
    }
}

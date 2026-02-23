<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

trait RequiresAnalysisLocationTobeSet
{
    public ?AnalysisLocation $analysisLocation;

    private function checkIfAnalysisLocationIsSet(): void
    {
        if ($this->analysisLocation === null) {
            throw new MissingAnalysisLocationSelectedException();
        }
    }
}

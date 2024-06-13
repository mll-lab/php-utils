<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use Illuminate\Support\Collection;

class RowForSingleIndex extends Row
{
    public SingleIndex $singleIndex;

    public string $sampleName;

    public string $project;

    public function __construct(SingleIndex $singleIndex, string $sampleID, string $sampleName, string $project)
    {
        $this->sampleID = $sampleID;
        $this->singleIndex = $singleIndex;
        $this->sampleName = $sampleName;
        $this->project = $project;
    }

    public function toString(): string
    {
        return implode(',', [
            $this->sampleID,
            $this->sampleName,
            $this->project,
            $this->singleIndex->index,
        ]);
    }

    /** @return Collection<int, string> */
    public function getColumns(): Collection
    {
        return new Collection([
            'Sample_ID', 'Sample_Name', 'Project', 'Index',
        ]);
    }
}

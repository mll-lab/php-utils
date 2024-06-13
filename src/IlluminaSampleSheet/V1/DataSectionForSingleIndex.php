<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use Illuminate\Support\Collection;

class DataSectionForSingleIndex extends DataSection
{
    /** @return Collection<int, string> */
    public function getColumns(): Collection
    {
        return new Collection([
            'Sample_ID',
            'Sample_Name',
            'Project',
            'Index',
        ]);
    }

    public function addRow(
        SingleIndex $singleIndex,
        string $sampleID,
        string $sampleName,
        string $project
    ): void {
        $this->rows->add([
            $sampleID,
            $sampleName,
            $project,
            $singleIndex->index,
        ]);
    }
}

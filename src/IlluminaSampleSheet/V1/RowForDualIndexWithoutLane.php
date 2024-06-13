<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use Illuminate\Support\Collection;

class RowForDualIndexWithoutLane extends Row
{
    public DualIndex $dualIndex;

    public string $sampleName;

    public string $samplePlate;

    public string $sampleWell;

    public string $sampleProject;

    public string $description;

    public function __construct(DualIndex $dualIndex, string $sampleID, string $sampleName, string $samplePlate, string $sampleWell, string $sampleProject, string $description)
    {
        $this->dualIndex = $dualIndex;
        $this->sampleID = $sampleID;
        $this->sampleName = $sampleName;
        $this->samplePlate = $samplePlate;
        $this->sampleWell = $sampleWell;
        $this->sampleProject = $sampleProject;
        $this->description = $description;
    }

    public function toString(): string
    {
        return implode(',', [
            $this->sampleID,
            $this->sampleName,
            $this->samplePlate,
            $this->sampleWell,
            $this->dualIndex->i7IndexID,
            $this->dualIndex->index,
            $this->dualIndex->i5IndexID,
            $this->dualIndex->index2,
            $this->sampleProject,
            $this->description,
        ]);
    }

    /** @return Collection<int, string> */
    public function getColumns(): Collection
    {
        return new Collection([
            'Sample_ID',
            'Sample_Name',
            'Sample_Plate',
            'Sample_Well',
            'I7_Index_ID',
            'Index',
            'I5_Index_ID',
            'Index2',
            'Sample_Project',
            'Description',
        ]);
    }
}

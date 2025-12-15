<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

class RowForDualIndexWithoutLane extends Row
{
    public function __construct(
        public DualIndex $dualIndex,
        string $sampleID,
        public string $sampleName,
        public string $samplePlate,
        public string $sampleWell,
        public string $sampleProject,
        public string $description
    ) {
        $this->sampleID = $sampleID;
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

    public function headerLine(): string
    {
        return 'Sample_ID,Sample_Name,Sample_Plate,Sample_Well,I7_Index_ID,Index,I5_Index_ID,Index2,Sample_Project,Description';
    }
}

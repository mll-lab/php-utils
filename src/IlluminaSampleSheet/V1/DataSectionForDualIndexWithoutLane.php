<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

class DataSectionForDualIndexWithoutLane extends DataSection
{
    protected const SAMPLE_ID_INDEX = 0;

    /** @return string[] */
    public function getColumns(): array
    {
        return [
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
        ];
    }

    public function addRow(
        DualIndex $dualIndex,
        string $sampleID,
        string $sampleName,
        string $samplePlate,
        string $sampleWell,
        string $sampleProject,
        string $description
    ): void {
        $this->rows->add([
            $sampleID,
            $sampleName,
            $samplePlate,
            $sampleWell,
            $dualIndex->i7IndexID,
            $dualIndex->index,
            $dualIndex->i5IndexID,
            $dualIndex->index2,
            $sampleProject,
            $description,
        ]);
    }
}

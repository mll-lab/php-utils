<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

class SampleSheetDataForDualIndexWithLane extends AbstractSampleSheetData
{
    /** @return string[] */
    public function getColumns(): array
    {
        return [
            'Lane',
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
        int $lane,
        string $sampleID,
        string $sampleName,
        string $samplePlate,
        string $sampleWell,
        string $sampleProject,
        string $description
    ): void {
        $this->rows[] = [
            $lane,
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
        ];
    }
}

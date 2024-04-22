<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class MiSeqDataSection extends DataSection
{
    public function dataSectionHeader(): string
    {
        return 'Sample_ID,Sample_Name,Sample_Plate,Sample_Well,Sample_Project,I7_Index_ID,Index,I5_Index_ID,Index2';
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class NovaSeqDataSection extends DataSection
{
    public function dataSectionHeader(): string
    {
        return 'Sample_ID,Sample_Name,Sample_Plate,Sample_Well,I7_Index_ID,Index,I5_Index_ID,Index2,Sample_Project,Description';
    }
}

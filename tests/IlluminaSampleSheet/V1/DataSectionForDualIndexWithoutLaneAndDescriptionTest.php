<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\V1\DataSectionForDualIndexWithoutLaneAndDescription;
use MLL\Utils\IlluminaSampleSheet\V1\DualIndex;
use MLL\Utils\IlluminaSampleSheet\V1\HeaderSection;
use MLL\Utils\IlluminaSampleSheet\V1\ReadsSection;
use MLL\Utils\IlluminaSampleSheet\V1\SampleSheet;
use MLL\Utils\IlluminaSampleSheet\V1\SettingsSection;
use PHPUnit\Framework\TestCase;

class DataSectionForDualIndexWithoutLaneAndDescriptionTest extends TestCase
{
    public function testShouldReturnExpectedResult(): void
    {
        // TODO missing: module, library prep kit, Index Kit
        $headerSection = new HeaderSection(
            '4', // TODO there is no ieam fileversion
            'DonalDuck', // TODO not there
            'Run7906-ROUTINE',
            '03.04.2024',
            'GenerateFASTQ',
            'MyApplication', // TODO no applicaiton
            'MyAssay', // TODO no assay
            'NA-ISP',
            'Amplicon',
        );

        $readsSection = new ReadsSection(151, 151);

        $sampleSheetDataSection = new DataSectionForDualIndexWithoutLaneAndDescription();
        $dualIndex1 = new DualIndex('R701', 'ATCACG', 'A501', 'TGAACCTT');

        $sampleSheetDataSection->addRow(
            $dualIndex1,
            '1',
            '24-026235-M001',
            'Run7906-ROUTINE',
            '',
            'Run7906-ROUTINE',
        );
        $dualIndex2 = new DualIndex('R701', 'ATCACG', 'A502', 'TGCTAAGT');

        $sampleSheetDataSection->addRow(
            $dualIndex2,
            '2',
            '24-032986-M002',
            'Run7906-ROUTINE',
            '',
            'Run7906-ROUTINE',
        );

        $settings = new SettingsSection();
        $novaSeqSampleSheet = new SampleSheet($headerSection, $readsSection, $settings, $sampleSheetDataSection);

        $expected = '[Header]
Experiment Name,Run7906-ROUTINE
Date,03.04.2024
Module,GenerateFASTQ - 3.0.1
Workflow,GenerateFASTQ
Library Prep Kit,Illumina DNA Prep
Index Kit,Custom
Description,NA-ISP
Chemistry,Amplicon
[Reads]
151
151
[Settings]

[Data]
Sample_ID,Sample_Name,Sample_Plate,Sample_Well,Sample_Project,I7_Index_ID,Index,I5_Index_ID,Index2
1,24-026235-M001,Run7906-ROUTINE,,Run7906-ROUTINE,R701,ATCACG,A501,TGAACCTT
2,24-032986-M002,Run7906-ROUTINE,,Run7906-ROUTINE,R701,ATCACG,A502,TGCTAAGT
';
        //        self::assertSame($expected, $novaSeqSampleSheet->toString());
    }
}

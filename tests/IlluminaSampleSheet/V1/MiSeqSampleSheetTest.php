<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\V1\MiSeqSample;
use MLL\Utils\IlluminaSampleSheet\V1\MiSeqSampleSheet;
use MLL\Utils\IlluminaSampleSheet\V1\ReadsSection;
use PHPUnit\Framework\TestCase;

class MiSeqSampleSheetTest extends TestCase
{
    public function testMiSeqSampleSheetToStringReturnsCorrectFormat(): void
    {
        $headerSection = $this->createMock(\MLL\Utils\IlluminaSampleSheet\V1\MiSeqHeaderSection::class);
        $readsSection = $this->createMock(ReadsSection::class);
        $dataSection = $this->createMock(\MLL\Utils\IlluminaSampleSheet\V1\DataSection::class);

        $miSeqSampleSheet = new MiSeqSampleSheet($headerSection, $readsSection, $dataSection);

        self::assertContains($headerSection, $miSeqSampleSheet->getSections());
        self::assertContains($readsSection, $miSeqSampleSheet->getSections());
        self::assertContains($dataSection, $miSeqSampleSheet->getSections());
    }

    public function testMiSeqSampleSheetToStringReturnsExpectedResult(): void
    {
        $headerSection = new \MLL\Utils\IlluminaSampleSheet\V1\MiSeqHeaderSection(
            'Run7906-ROUTINE',
            '03.04.2024',
            'GenerateFASTQ - 3.0.1',
            'GenerateFASTQ',
            'Illumina DNA Prep',
            'Custom',
            'NA-ISP',
            'Amplicon'
        );

        $readsSection = new ReadsSection(150, 150);

        $dataSection = new \MLL\Utils\IlluminaSampleSheet\V1\MiSeqDataSection();

        $dataSection->addSample(new MiSeqSample('1', 'Sample-001-M001', 'RunXXXX-PLATE', '', 'RunXXXX-PROJECT', 'R701', 'ATCACG', 'A501', 'TGAACCTT'));
        $dataSection->addSample(new MiSeqSample('2', 'Sample-002-M002', 'RunXXXX-PLATE', '', 'RunXXXX-PROJECT', 'R701', 'ATCACG', 'A502', 'TGCTAAGT'));
        $dataSection->addSample(new \MLL\Utils\IlluminaSampleSheet\V1\MiSeqSample('3', 'Sample-003-M003', 'RunXXXX-PLATE', '', 'RunXXXX-PROJECT', 'R701', 'ATCACG', 'A503', 'TGTTCTCT'));

        $miSeqSampleSheet = new MiSeqSampleSheet($headerSection, $readsSection, $dataSection);

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
150
150
[Settings]
[Data]
Sample_ID,Sample_Name,Sample_Plate,Sample_Well,Sample_Project,I7_Index_ID,Index,I5_Index_ID,Index2
1,Sample-001-M001,RunXXXX-PLATE,,RunXXXX-PROJECT,R701,ATCACG,A501,TGAACCTT
2,Sample-002-M002,RunXXXX-PLATE,,RunXXXX-PROJECT,R701,ATCACG,A502,TGCTAAGT
3,Sample-003-M003,RunXXXX-PLATE,,RunXXXX-PROJECT,R701,ATCACG,A503,TGTTCTCT
';
        self::assertSame($expected, $miSeqSampleSheet->toString());
    }
}

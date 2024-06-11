<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\SampleSheetVersions;
use MLL\Utils\IlluminaSampleSheet\V1\DataSection;
use MLL\Utils\IlluminaSampleSheet\V1\NovaSeqHeaderSection;
use MLL\Utils\IlluminaSampleSheet\V1\NovaSeqSampleSheet;
use MLL\Utils\IlluminaSampleSheet\V1\ReadsSection;
use MLL\Utils\IlluminaSampleSheet\V1\SampleSheetData;
use MLL\Utils\IlluminaSampleSheet\V1\SettingsSection;
use PHPUnit\Framework\TestCase;

class NovaSeqSampleSheetTest extends TestCase
{

    public function testSomething(): void
    {
        $sampleSheet = SampleSheetVersions::createSampleSheet(SampleSheetVersions::V1);
        self::assertInstanceOf(NovaSeqSampleSheet::class, $sampleSheet);

        $columns = ['Sample_ID', 'Sample_Name', 'Sample_Plate', 'Sample_Well', 'I7_Index_ID', 'Index', 'I5_Index_ID', 'Index2', 'Sample_Project', 'Description'];
        $rows = [
            ['1', 'Sample-001-M001', 'RunXXXX-PLATE', '', 'UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG', 'RunXXXX-PROJECT', 'description'],
            ['2',  'Sample-002-M002', 'RunXXXX-PLATE', '', 'UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA', 'RunXXXX-PROJECT', 'description'],
            ['3', 'Sample-003-M003', 'RunXXXX-PLATE', '', 'UDP0092', 'GAACATCG', 'UDP0092', 'TCGACAAG', 'RunXXXX-PROJECT', 'description'],
        ];

        $sampleSheet
            ->setHeaderData(
                '4',
                'DonalDuck',
                'MyExperiment',
                '19.04.2024',
                'MyWorkflow',
                'MyApplication',
                'MyAssay',
                'MyDescription',
                'MyChemistry',
            )
            ->setReadsData(101, 101)
            ->setSettingsData(
                'AGATCGGAAGAGCACACGTCTGAACTCCAGTCA',
                'AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT'
            )
            ->setData($columns, $rows);



        $expected = '[Header]
IEMFileVersion,4
Investigator Name,DonalDuck
Experiment Name,MyExperiment
Date,19.04.2024
Workflow,MyWorkflow
Application,MyApplication
Assay,MyAssay
Description,MyDescription
Chemistry,MyChemistry
[Reads]
101
101
[Settings]
Adapter,AGATCGGAAGAGCACACGTCTGAACTCCAGTCA
AdapterRead2,AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT
[Data]
Sample_ID,Sample_Name,Sample_Plate,Sample_Well,I7_Index_ID,Index,I5_Index_ID,Index2,Sample_Project,Description
1,Sample-001-M001,RunXXXX-PLATE,,UDP0090,TCAGGCTT,UDP0090,ATCATGCG,RunXXXX-PROJECT,description
2,Sample-002-M002,RunXXXX-PLATE,,UDP0091,CCTTGTAG,UDP0091,CCTTGGAA,RunXXXX-PROJECT,description
3,Sample-003-M003,RunXXXX-PLATE,,UDP0092,GAACATCG,UDP0092,TCGACAAG,RunXXXX-PROJECT,description
';
        self::assertSame($expected, $sampleSheet->toString());


    }
    public function testNovaSeqStandardSampleSheetToStringReturnsExpectedResult(): void
    {
        $headerSection = new NovaSeqHeaderSection(
            '4',
            'DonalDuck',
            'MyExperiment',
            '19.04.2024',
            'MyWorkflow',
            'MyApplication',
            'MyAssay',
            'MyDescription',
            'MyChemistry',
        );

        $readsSection = new ReadsSection(101, 101);

        $columns = ['Sample_ID', 'Sample_Name', 'Sample_Plate', 'Sample_Well', 'I7_Index_ID', 'Index', 'I5_Index_ID', 'Index2', 'Sample_Project', 'Description'];
        $rows = [
            ['1', 'Sample-001-M001', 'RunXXXX-PLATE', '', 'UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG', 'RunXXXX-PROJECT', 'description'],
            ['2',  'Sample-002-M002', 'RunXXXX-PLATE', '', 'UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA', 'RunXXXX-PROJECT', 'description'],
            ['3', 'Sample-003-M003', 'RunXXXX-PLATE', '', 'UDP0092', 'GAACATCG', 'UDP0092', 'TCGACAAG', 'RunXXXX-PROJECT', 'description'],
        ];

        $sampleSheetData = new SampleSheetData($columns, $rows);
        $dataSection = new DataSection($sampleSheetData);

        $settings = new SettingsSection('AGATCGGAAGAGCACACGTCTGAACTCCAGTCA', 'AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT');
        $novaSeqSampleSheet = new NovaSeqSampleSheet($headerSection, $readsSection, $settings, $dataSection);

        $expected = '[Header]
IEMFileVersion,4
Investigator Name,DonalDuck
Experiment Name,MyExperiment
Date,19.04.2024
Workflow,MyWorkflow
Application,MyApplication
Assay,MyAssay
Description,MyDescription
Chemistry,MyChemistry
[Reads]
101
101
[Settings]
Adapter,AGATCGGAAGAGCACACGTCTGAACTCCAGTCA
AdapterRead2,AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT
[Data]
Sample_ID,Sample_Name,Sample_Plate,Sample_Well,I7_Index_ID,Index,I5_Index_ID,Index2,Sample_Project,Description
1,Sample-001-M001,RunXXXX-PLATE,,UDP0090,TCAGGCTT,UDP0090,ATCATGCG,RunXXXX-PROJECT,description
2,Sample-002-M002,RunXXXX-PLATE,,UDP0091,CCTTGTAG,UDP0091,CCTTGGAA,RunXXXX-PROJECT,description
3,Sample-003-M003,RunXXXX-PLATE,,UDP0092,GAACATCG,UDP0092,TCGACAAG,RunXXXX-PROJECT,description
';
        self::assertSame($expected, $novaSeqSampleSheet->toString());
    }

    public function testNovaSeqXpSampleSheetWithLanesToStringReturnsExpectedResult(): void
    {
        $headerSection = new NovaSeqHeaderSection(
            '4',
            'DonalDuck',
            'MyExperiment',
            '19.04.2024',
            'MyWorkflow',
            'MyApplication',
            'MyAssay',
            'MyDescription',
            'MyChemistry',
        );

        $readsSection = new ReadsSection(101, 101);

        $columns = ['Lane', 'Sample_ID', 'Sample_Name', 'Sample_Plate', 'Sample_Well', 'I7_Index_ID', 'Index', 'I5_Index_ID', 'Index2', 'Sample_Project', 'Description'];
        $rows = [
            [2, '1', 'Sample-001-M001', 'RunXXXX-PLATE', '', 'UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG', 'RunXXXX-PROJECT', 'description'],
            [1, '2', 'Sample-002-M002', 'RunXXXX-PLATE', '', 'UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA', 'RunXXXX-PROJECT', 'description'],
            [4, '3', 'Sample-003-M003', 'RunXXXX-PLATE', '', 'UDP0092', 'GAACATCG', 'UDP0092', 'TCGACAAG', 'RunXXXX-PROJECT', 'description'],
        ];

        $sampleSheetData = new SampleSheetData($columns, $rows);
        $dataSection = new DataSection($sampleSheetData);

        $settings = new SettingsSection('AGATCGGAAGAGCACACGTCTGAACTCCAGTCA', 'AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT');
        $novaSeqSampleSheet = new NovaSeqSampleSheet($headerSection, $readsSection, $settings, $dataSection);

        $expected = '[Header]
IEMFileVersion,4
Investigator Name,DonalDuck
Experiment Name,MyExperiment
Date,19.04.2024
Workflow,MyWorkflow
Application,MyApplication
Assay,MyAssay
Description,MyDescription
Chemistry,MyChemistry
[Reads]
101
101
[Settings]
Adapter,AGATCGGAAGAGCACACGTCTGAACTCCAGTCA
AdapterRead2,AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT
[Data]
Lane,Sample_ID,Sample_Name,Sample_Plate,Sample_Well,I7_Index_ID,Index,I5_Index_ID,Index2,Sample_Project,Description
2,1,Sample-001-M001,RunXXXX-PLATE,,UDP0090,TCAGGCTT,UDP0090,ATCATGCG,RunXXXX-PROJECT,description
1,2,Sample-002-M002,RunXXXX-PLATE,,UDP0091,CCTTGTAG,UDP0091,CCTTGGAA,RunXXXX-PROJECT,description
4,3,Sample-003-M003,RunXXXX-PLATE,,UDP0092,GAACATCG,UDP0092,TCGACAAG,RunXXXX-PROJECT,description
';
        self::assertSame($expected, $novaSeqSampleSheet->toString());
    }
}

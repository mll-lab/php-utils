<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V1\DataSection;
use MLL\Utils\IlluminaSampleSheet\V1\DualIndex;
use MLL\Utils\IlluminaSampleSheet\V1\HeaderSection;
use MLL\Utils\IlluminaSampleSheet\V1\ReadsSection;
use MLL\Utils\IlluminaSampleSheet\V1\RowForDualIndexWithLane;
use MLL\Utils\IlluminaSampleSheet\V1\RowForDualIndexWithoutLane;
use MLL\Utils\IlluminaSampleSheet\V1\SampleSheet;
use MLL\Utils\IlluminaSampleSheet\V1\SettingsSection;
use PHPUnit\Framework\TestCase;

class DataSectionTest extends TestCase
{
    public function testDataSectionWithDualIndexWithLaneShouldReturnExpectedResult(): void
    {
        $headerSection = new HeaderSection(
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

        $sampleSheetData = new DataSection(RowForDualIndexWithLane::class);
        $sampleSheetData->addRow(
            new RowForDualIndexWithLane(
                new DualIndex('UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG'),
                2,
                '1',
                'Sample-001-M001',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );
        $sampleSheetData->addRow(
            new RowForDualIndexWithLane(
                new DualIndex('UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA'),
                1,
                '2',
                'Sample-002-M002',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );
        $sampleSheetData->addRow(
            new RowForDualIndexWithLane(
                new DualIndex('UDP0092', 'GAACATCG', 'UDP0092', 'TCGACAAG'),
                4,
                '3',
                'Sample-003-M003',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );

        $settings = new SettingsSection('AGATCGGAAGAGCACACGTCTGAACTCCAGTCA', 'AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT');
        $novaSeqSampleSheet = new SampleSheet($headerSection, $readsSection, $settings, $sampleSheetData);

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

    public function testDataSectionWithDualIndexWithLaneShouldThrowExceptionWhenSampleIDIsDuplicated(): void
    {
        $headerSection = new HeaderSection(
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

        /** @var DataSection<RowForDualIndexWithLane> $sampleSheetDataSection */
        $sampleSheetDataSection = new DataSection(RowForDualIndexWithLane::class);
        $dualIndex1 = new DualIndex('UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG');

        $sampleSheetDataSection->addRow(
            new RowForDualIndexWithLane(
                $dualIndex1,
                1,
                '1',
                'Sample-001-M001',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );
        $dualIndex2 = new DualIndex('UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA');

        $sampleSheetDataSection->addRow(
            new RowForDualIndexWithLane(
                $dualIndex2,
                2,
                '1',
                'Sample-002-M002',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );

        $dualIndex3 = new DualIndex('UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA');

        $sampleSheetDataSection->addRow(
            new RowForDualIndexWithLane(
                $dualIndex3,
                2,
                '3',
                'Sample-002-M002',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );

        $dualIndex4 = new DualIndex('UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA');

        $sampleSheetDataSection->addRow(
            new RowForDualIndexWithLane(
                $dualIndex4,
                2,
                '3',
                'Sample-002-M002',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );

        $settings = new SettingsSection('AGATCGGAAGAGCACACGTCTGAACTCCAGTCA', 'AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT');
        $novaSeqSampleSheet = new SampleSheet($headerSection, $readsSection, $settings, $sampleSheetDataSection);

        $this->expectException(IlluminaSampleSheetException::class);
        $this->expectExceptionMessage('Sample_ID values must be distinct. Duplicated SampleIDs: 1, 3');
        $novaSeqSampleSheet->toString();
    }

    public function testDataSectionWithDualIndexWithLaneWorksNotWhenRowWithWrongTypeIsAdded(): void
    {
        $sampleSheetDataSection = new DataSection(RowForDualIndexWithLane::class);

        $dualIndex = new DualIndex('UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG');
        $sampleSheetDataSection->addRow(
            // @phpstan-ignore-next-line expecting a type error due to mismatching row types
            new RowForDualIndexWithoutLane(
                $dualIndex,
                '1',
                'Sample-001-M001',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );

        $this->expectNotToPerformAssertions();
    }

    public function testDataSectionWithDualIndexWithoutLaneShouldReturnExpectedResult(): void
    {
        $headerSection = new HeaderSection(
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
        /** @var DataSection<RowForDualIndexWithoutLane> $sampleSheetDataSection */
        $sampleSheetDataSection = new DataSection(RowForDualIndexWithoutLane::class);
        $dualIndex1 = new DualIndex('UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG');

        $sampleSheetDataSection->addRow(
            new RowForDualIndexWithoutLane(
                $dualIndex1,
                '1',
                'Sample-001-M001',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );
        $dualIndex2 = new DualIndex('UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA');

        $sampleSheetDataSection->addRow(
            new RowForDualIndexWithoutLane(
                $dualIndex2,
                '2',
                'Sample-002-M002',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );
        $dualIndex3 = new DualIndex('UDP0092', 'GAACATCG', 'UDP0092', 'TCGACAAG');

        $sampleSheetDataSection->addRow(
            new RowForDualIndexWithoutLane(
                $dualIndex3,
                '3',
                'Sample-003-M003',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );

        $settings = new SettingsSection('AGATCGGAAGAGCACACGTCTGAACTCCAGTCA', 'AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT');
        $novaSeqSampleSheet = new SampleSheet($headerSection, $readsSection, $settings, $sampleSheetDataSection);

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

    public function testDataSectionWithDualIndexWithoutLaneShouldThrowExceptionWhenSampleIDIsDuplicated(): void
    {
        $headerSection = new HeaderSection(
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

        $sampleSheetDataSection = new DataSection(RowForDualIndexWithoutLane::class);
        $dualIndex1 = new DualIndex('UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG');

        $sampleSheetDataSection->addRow(
            new RowForDualIndexWithoutLane(
                $dualIndex1,
                '1',
                'Sample-001-M001',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );
        $dualIndex2 = new DualIndex('UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA');

        $sampleSheetDataSection->addRow(
            new RowForDualIndexWithoutLane(
                $dualIndex2,
                '1',
                'Sample-002-M002',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );

        $settings = new SettingsSection('AGATCGGAAGAGCACACGTCTGAACTCCAGTCA', 'AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT');
        $novaSeqSampleSheet = new SampleSheet($headerSection, $readsSection, $settings, $sampleSheetDataSection);

        $this->expectException(IlluminaSampleSheetException::class);
        $this->expectExceptionMessage('Sample_ID values must be distinct. Duplicated SampleIDs: 1');
        $novaSeqSampleSheet->toString();
    }

    public function testDataSectionWithDualIndexWithoutLaneWorksNotWhenRowWithWrongTypeIsAdded(): void
    {
        $sampleSheetDataSection = new DataSection(RowForDualIndexWithoutLane::class);

        $dualIndex = new DualIndex('UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG');
        $sampleSheetDataSection->addRow(
            // @phpstan-ignore-next-line expecting a type error due to mismatching row types
            new RowForDualIndexWithLane(
                $dualIndex,
                1,
                '1',
                'Sample-001-M001',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );

        $this->expectNotToPerformAssertions();
    }
}

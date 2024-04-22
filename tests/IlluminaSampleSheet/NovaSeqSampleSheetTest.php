<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet;

use MLL\Utils\IlluminaSampleSheet\DataSection;
use MLL\Utils\IlluminaSampleSheet\NovaSeqDataSection;
use MLL\Utils\IlluminaSampleSheet\NovaSeqHeaderSection;
use MLL\Utils\IlluminaSampleSheet\NovaSeqSample;
use MLL\Utils\IlluminaSampleSheet\NovaSeqSampleSheet;
use MLL\Utils\IlluminaSampleSheet\ReadsSection;
use MLL\Utils\IlluminaSampleSheet\SettingsSection;
use PHPUnit\Framework\TestCase;

class NovaSeqSampleSheetTest extends TestCase
{
    public function testNovaSeqSampleSheetAddsSectionsOnConstruction(): void
    {
        $headerSection = $this->createMock(NovaSeqHeaderSection::class);
        $readsSection = $this->createMock(ReadsSection::class);
        $settingsSection = $this->createMock(SettingsSection::class);
        $dataSection = $this->createMock(DataSection::class);

        $novaSeqSampleSheet = new NovaSeqSampleSheet($headerSection, $readsSection, $settingsSection, $dataSection);

        self::assertContains($headerSection, $novaSeqSampleSheet->getSections());
        self::assertContains($readsSection, $novaSeqSampleSheet->getSections());
        self::assertContains($settingsSection, $novaSeqSampleSheet->getSections());
        self::assertContains($dataSection, $novaSeqSampleSheet->getSections());
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

        $dataSection = new NovaSeqDataSection();

        $dataSection->addSample(new NovaSeqSample('1', 'Sample-001-M001', 'RunXXXX-PLATE', '', 'UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG', 'RunXXXX-PROJECT', 'description'));
        $dataSection->addSample(new NovaSeqSample('2', 'Sample-002-M002', 'RunXXXX-PLATE', '', 'UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA', 'RunXXXX-PROJECT', 'description'));
        $dataSection->addSample(new NovaSeqSample('3', 'Sample-003-M003', 'RunXXXX-PLATE', '', 'UDP0092', 'GAACATCG', 'UDP0092', 'TCGACAAG', 'RunXXXX-PROJECT', 'description'));

        $settings = new SettingsSection('AGATCGGAAGAGCACACGTCTGAACTCCAGTCA', 'AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT');
        $miSeqSampleSheet = new NovaSeqSampleSheet($headerSection, $readsSection, $settings, $dataSection);

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
        self::assertSame($expected, $miSeqSampleSheet->toString());
    }
}

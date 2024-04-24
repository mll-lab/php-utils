<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet;

use MLL\Utils\IlluminaSampleSheet\V1\NovaSeqHeaderSection;
use MLL\Utils\IlluminaSampleSheet\V1\NovaSeqXpDataSection;
use MLL\Utils\IlluminaSampleSheet\V1\NovaSeqXpSample;
use MLL\Utils\IlluminaSampleSheet\V1\SettingsSection;
use PHPUnit\Framework\TestCase;

class NovaSeqXpSampleSheetTest extends TestCase
{
    public function testNovaSeqSampleSheetAddsSectionsOnConstruction(): void
    {
        $headerSection = $this->createMock(NovaSeqHeaderSection::class);
        $readsSection = $this->createMock(\MLL\Utils\IlluminaSampleSheet\V1\ReadsSection::class);
        $settingsSection = $this->createMock(SettingsSection::class);
        $dataSection = $this->createMock(\MLL\Utils\IlluminaSampleSheet\V1\DataSection::class);

        $novaSeqSampleSheet = new \MLL\Utils\IlluminaSampleSheet\V1\NovaSeqXpSampleSheet($headerSection, $readsSection, $settingsSection, $dataSection);

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

        $readsSection = new \MLL\Utils\IlluminaSampleSheet\V1\ReadsSection(101, 101);

        $dataSection = new NovaSeqXpDataSection();

        $dataSection->addSample(new NovaSeqXpSample('2', '1', 'Sample-001-M001', 'RunXXXX-PLATE', '', 'UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG', 'RunXXXX-PROJECT', 'description'));
        $dataSection->addSample(new NovaSeqXpSample('1', '2', 'Sample-002-M002', 'RunXXXX-PLATE', '', 'UDP0091', 'CCTTGTAG', 'UDP0091', 'CCTTGGAA', 'RunXXXX-PROJECT', 'description'));
        $dataSection->addSample(new NovaSeqXpSample('4', '3', 'Sample-003-M003', 'RunXXXX-PLATE', '', 'UDP0092', 'GAACATCG', 'UDP0092', 'TCGACAAG', 'RunXXXX-PROJECT', 'description'));

        $settings = new SettingsSection('AGATCGGAAGAGCACACGTCTGAACTCCAGTCA', 'AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT');
        $miSeqSampleSheet = new \MLL\Utils\IlluminaSampleSheet\V1\NovaSeqSampleSheet($headerSection, $readsSection, $settings, $dataSection);

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
        self::assertSame($expected, $miSeqSampleSheet->toString());
    }
}

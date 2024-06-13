<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\V1\DataSectionForSingleIndex;
use MLL\Utils\IlluminaSampleSheet\V1\HeaderSection;
use MLL\Utils\IlluminaSampleSheet\V1\ReadsSection;
use MLL\Utils\IlluminaSampleSheet\V1\SampleSheet;
use MLL\Utils\IlluminaSampleSheet\V1\SettingsSection;
use MLL\Utils\IlluminaSampleSheet\V1\SingleIndex;
use PHPUnit\Framework\TestCase;

class DataSectionForSingleIndexTest extends TestCase
{
    public function testShouldReturnExpectedResult(): void
    {
        $headerSection = new HeaderSection(
            '3',
            'foo',
            'Run1-IMMUNORECEPTOR',
            '29.12.2022',
            'GenerateFASTQ',
            'MyApplication', // TODO not there
            'MyAssay',  // TODO not there
            'Sequencing',
            'MyChemistry',  // TODO not there
        );

        $readsSection = new ReadsSection(301, 301);

        $sampleSheetData = new DataSectionForSingleIndex();
        $sampleSheetData->addRow(
            new SingleIndex('ATCACG'),
            'static-M001',
            'static-M001',
            'Run1-IMMUNORECEPTOR',
        );
        $sampleSheetData->addRow(
            new SingleIndex('ATCACG'),
            'static-M002',
            'static-M002',
            'Run1-IMMUNORECEPTOR',
        );

        // TODO Variant Caller missing
        $settings = new SettingsSection('AGATCGGAAGAGCACACGTCTGAACTCCAGTCA', 'AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT');
        $novaSeqSampleSheet = new SampleSheet($headerSection, $readsSection, $settings, $sampleSheetData);

        $expected = '[Header]
IEMFileVersion,3
Experiment Name,Run1-IMMUNORECEPTOR
Investigator Name,foo
Date,29.12.2022
Workflow,GenerateFASTQ
Description,Sequencing
[Reads]
301
301
[Settings]
VariantCaller,None
Adapter,AGATCGGAAGAGCACACGTCTGAACTCCAGTCA
AdapterRead2,AGATCGGAAGAGCGTCGTGTAGGGAAAGAGTGT
[Data]
Sample_ID,Sample_Name,Project,Index
static-M001,static-M001,Run1-IMMUNORECEPTOR,ATCACG
static-M002,static-M002,Run1-IMMUNORECEPTOR,ATCACG
';
        //        self::assertSame($expected, $novaSeqSampleSheet->toString());
    }
}

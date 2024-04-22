<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet;

use MLL\Utils\IlluminaSampleSheet\BclConvertDataSection;
use MLL\Utils\IlluminaSampleSheet\BclConvertSettingsSection;
use MLL\Utils\IlluminaSampleSheet\CloudDataSection;
use MLL\Utils\IlluminaSampleSheet\CloudSettingsSection;
use MLL\Utils\IlluminaSampleSheet\NovaSeqXCloudHeaderSection;
use MLL\Utils\IlluminaSampleSheet\NovaSeqXCloudReadsSection;
use MLL\Utils\IlluminaSampleSheet\NovaSeqXCloudSampleSheet;
use MLL\Utils\IlluminaSampleSheet\NovaSeqXCloudSequencingSettingsSection;
use PHPUnit\Framework\TestCase;

class NovaSeqXCloudSampleSheetTest extends TestCase
{
    public function testNovaSeqXCloudSampleSheetToStringReturnsExpectedResult(): void
    {
        $headerSection = new NovaSeqXCloudHeaderSection(
            '1',
            'Run1',
            'Platform1',
            'Orientation1'
        );

        $readsSection = new NovaSeqXCloudReadsSection(
            100,
            101,
            10,
            11
        );
        $sequenceSettingsSection = new NovaSeqXCloudSequencingSettingsSection('Settings1');

        $bclConvertSettingsSection = new BclConvertSettingsSection('1.0.0', '0', 'gzip');

        $bclConvertDataSection = new BclConvertDataSection();
        $bclConvertDataSection->addSample(1, 'Sample1', 'Index1', 'Index2', 'Cycles1', 'Adapter1', 'Adapter2');
        $bclConvertDataSection->addSample(2, 'Sample2', 'Index3', 'Index4', 'Cycles2', 'Adapter3', 'Adapter4');
        $bclConvertDataSection->addSample(3, 'Sample3', 'Index5', 'Index6', 'Cycles3', 'Adapter5', 'Adapter6');

        $cloudSettingsSection = new CloudSettingsSection('1.0.0', 'Workflow1', 'Pipeline1');

        $cloudDataSection = new CloudDataSection();
        $cloudDataSection->addSample('Sample4', 'Project1', 'Library1', 'Kit1', 'AdapterKit1');
        $cloudDataSection->addSample('Sample5', 'Project2', 'Library2', 'Kit2', 'AdapterKit2');
        $cloudDataSection->addSample('Sample6', 'Project3', 'Library3', 'Kit3', 'AdapterKit3');

        $novaSeqXCloudSampleSheet = new NovaSeqXCloudSampleSheet(
            $headerSection,
            $readsSection,
            $sequenceSettingsSection,
            $bclConvertSettingsSection,
            $bclConvertDataSection,
            $cloudSettingsSection,
            $cloudDataSection
        );

        $expected = '[Header]
FileFormatVersion,1
RunName,Run1
InstrumentPlatform,Platform1
IndexOrientation,Orientation1

[Reads]
Read1Cycles,100
Read2Cycles,101
Index1Cycles,10
Index2Cycles,11

[Sequencing_Settings]
LibraryPrepKits,Settings1

[BCLConvert_Settings]
SoftwareVersion,1.0.0
TrimUMI,0
FastqCompressionFormat,gzip

[BCLConvert_Data]
Lane,Sample_ID,Index,Index2,OverrideCycles,AdapterRead1,AdapterRead2
1,Sample1,Index1,Index2,Cycles1,Adapter1,Adapter2
2,Sample2,Index3,Index4,Cycles2,Adapter3,Adapter4
3,Sample3,Index5,Index6,Cycles3,Adapter5,Adapter6

[Cloud_Settings]
GeneratedVersion,1.0.0
Cloud_Workflow,Workflow1
BCLConvert_Pipeline,Pipeline1

[Cloud_Data]
Sample_ID,ProjectName,LibraryName,LibraryPrepKitName,IndexAdapterKitName
Sample4,Project1,Library1,Kit1,AdapterKit1
Sample5,Project2,Library2,Kit2,AdapterKit2
Sample6,Project3,Library3,Kit3,AdapterKit3
';

        self::assertEquals($expected, $novaSeqXCloudSampleSheet->toString());
    }
}

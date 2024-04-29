<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\V2\BclConvertDataSection;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvertSettingsSection;
use MLL\Utils\IlluminaSampleSheet\V2\HeaderSection;
use MLL\Utils\IlluminaSampleSheet\V2\NovaSeqXSampleSheet;
use MLL\Utils\IlluminaSampleSheet\V2\ReadsSection;
use PHPUnit\Framework\TestCase;

class NovaSeqXCloudSampleSheetTest extends TestCase
{
    public function testNovaSeqXCloudSampleSheetToStringReturnsExpectedResult(): void
    {
        $headerSection = new HeaderSection(
            'Run1',
        );
        $headerSection->setInstrumentPlatform('NovaSeqXSeries');
        $headerSection->setCustomParam('IndexOrientation', 'Orientation1');

        $readsSection = new ReadsSection(
            100,
            101,
            10,
            11
        );

        $bclConvertSettingsSection = new BclConvertSettingsSection('1.0.0', \MLL\Utils\IlluminaSampleSheet\V2\Enums\FastQCompressionFormat::GZIP());
        $bclConvertSettingsSection->setTrimUMI(false);

        $bclConvertDataSection = new BclConvertDataSection();
        $bclConvertDataSection->addSample(1, 'Sample1', 'Index1', 'Index2', 'Cycles1', 'Adapter1', 'Adapter2');
        $bclConvertDataSection->addSample(2, 'Sample2', 'Index3', 'Index4', 'Cycles2', 'Adapter3', 'Adapter4');
        $bclConvertDataSection->addSample(3, 'Sample3', 'Index5', 'Index6', 'Cycles3', 'Adapter5', 'Adapter6');

        $novaSeqXCloudSampleSheet = new NovaSeqXSampleSheet(
            $headerSection,
            $readsSection,
            $bclConvertSettingsSection,
            $bclConvertDataSection,
        );

        $expected = '[Header]
FileFormatVersion,2
RunName,Run1
InstrumentPlatform,NovaSeqXSeries
Custom_IndexOrientation,Orientation1

[Reads]
Read1Cycles,100
Read2Cycles,101
Index1Cycles,10
Index2Cycles,11

[BCLConvert_Settings]
SoftwareVersion,1.0.0
FastqCompressionFormat,gzip
TrimUMI,0

[BCLConvert_Data]
Lane,Sample_ID,Index,Index2,OverrideCycles,AdapterRead1,AdapterRead2
1,Sample1,Index1,Index2,Cycles1,Adapter1,Adapter2
2,Sample2,Index3,Index4,Cycles2,Adapter3,Adapter4
3,Sample3,Index5,Index6,Cycles3,Adapter5,Adapter6
';

        self::assertEquals($expected, $novaSeqXCloudSampleSheet->toString());
    }
}

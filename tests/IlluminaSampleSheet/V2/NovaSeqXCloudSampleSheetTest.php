<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclConvertSection;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclSample;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\DataSection;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycles;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\SettingsSection;
use MLL\Utils\IlluminaSampleSheet\V2\Enums\FastQCompressionFormat;
use MLL\Utils\IlluminaSampleSheet\V2\HeaderSection;
use MLL\Utils\IlluminaSampleSheet\V2\NovaSeqXSampleSheet;
use PHPUnit\Framework\TestCase;

final class NovaSeqXCloudSampleSheetTest extends TestCase
{
    public function testNovaSeqXCloudSampleSheetToStringReturnsExpectedResult(): void
    {
        $headerSection = new HeaderSection('Run1');
        $headerSection->instrumentPlatform = 'NovaSeqXSeries';
        $headerSection->setCustomParam('TestKey', 'TestValue');

        $bclConvertSettingsSection = new SettingsSection('1.0.0', FastQCompressionFormat::GZIP());
        $bclConvertSettingsSection->trimUMI = false;

        $bclConvertDataSection = new DataSection();

        $overrideCycles = new OverrideCycles($bclConvertDataSection, 'U7N1Y143', 'I8', 'I8', 'U7N1Y143');
        $bclSample = new BclSample(1, 'Sample1', 'Index1', $overrideCycles);
        $bclSample->index2 = 'Index2';

        $bclSample->adapterRead1 = 'Adapter1';
        $bclSample->adapterRead2 = 'Adapter2';

        $overrideCycles1 = new OverrideCycles($bclConvertDataSection, 'Y151', 'I8', 'U10', 'Y151');
        $bclSample1 = new BclSample(2, 'Sample2', 'Index3', $overrideCycles1);
        $bclSample1->index2 = 'Index4';

        $bclSample1->adapterRead1 = 'Adapter3';
        $bclSample1->adapterRead2 = 'Adapter4';

        $overrideCycles2 = new OverrideCycles($bclConvertDataSection, 'Y151', 'I8', 'I8', 'U10N12Y127');
        $bclSample2 = new BclSample(3, 'Sample3', 'Index5', $overrideCycles2);
        $bclSample2->index2 = 'Index6';

        $bclSample2->adapterRead1 = 'Adapter5';
        $bclSample2->adapterRead2 = 'Adapter6';

        $overrideCycles3 = new OverrideCycles($bclConvertDataSection, 'Y101', 'I8', 'I8', 'Y101');
        $bclSample3 = new BclSample(8, 'Sample4', 'Index5', $overrideCycles3);
        $bclSample3->index2 = 'Index6';

        $bclSample3->adapterRead1 = 'Adapter5';
        $bclSample3->adapterRead2 = 'Adapter6';

        $overrideCycles4 = new OverrideCycles($bclConvertDataSection, 'U5N2Y94', 'I8', 'I8', 'U5N2Y94');
        $bclSample4 = new BclSample(6, 'Sample5', 'Index5', $overrideCycles4);
        $bclSample4->index2 = 'Index6';

        $bclSample4->adapterRead1 = 'Adapter5';
        $bclSample4->adapterRead2 = 'Adapter6';

        $bclConvertDataSection->addSample($bclSample);
        $bclConvertDataSection->addSample($bclSample1);
        $bclConvertDataSection->addSample($bclSample2);
        $bclConvertDataSection->addSample($bclSample3);
        $bclConvertDataSection->addSample($bclSample4);

        $bclConvertSection = new BclConvertSection($bclConvertSettingsSection, $bclConvertDataSection);

        $novaSeqXCloudSampleSheet = new NovaSeqXSampleSheet(
            $headerSection,
            $bclConvertSection,
        );

        $expected = '[Header]
FileFormatVersion,2
RunName,Run1
IndexOrientation,Forward
InstrumentPlatform,NovaSeqXSeries
Custom_TestKey,TestValue

[Reads]
Read1Cycles,151
Read2Cycles,151
Index1Cycles,8
Index2Cycles,10

[BCLConvert_Settings]
SoftwareVersion,1.0.0
FastqCompressionFormat,gzip
TrimUMI,0

[BCLConvert_Data]
Lane,Sample_ID,Index,Index2,OverrideCycles,AdapterRead1,AdapterRead2
1,Sample1,Index1,Index2,U7N1Y143;I8;N2I8;U7N1Y143,Adapter1,Adapter2
2,Sample2,Index3,Index4,Y151;I8;U10;Y151,Adapter3,Adapter4
3,Sample3,Index5,Index6,Y151;I8;N2I8;U10N12Y127N2,Adapter5,Adapter6
8,Sample4,Index5,Index6,Y101N50;I8;N2I8;Y101N50,Adapter5,Adapter6
6,Sample5,Index5,Index6,U5N2Y94N50;I8;N2I8;U5N2Y94N50,Adapter5,Adapter6
';

        self::assertSame($expected, $novaSeqXCloudSampleSheet->toString());
    }
}

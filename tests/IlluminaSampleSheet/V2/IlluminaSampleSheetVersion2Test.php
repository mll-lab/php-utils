<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclSample;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\NovaSeqX1_5B;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycles;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvertSoftwareVersion;
use MLL\Utils\IlluminaSampleSheet\V2\IlluminaSampleSheetVersion2;
use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;
use MLL\Utils\IlluminaSampleSheet\V2\InstrumentPlatform;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\BclConvertDataSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\BclConvertSettingsSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\CloudDataItem;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\CloudDataSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\CloudSettingsSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\HeaderSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\ReadsSection;
use PHPUnit\Framework\TestCase;

final class IlluminaSampleSheetVersion2Test extends TestCase
{
    public function testNovaSeqXCloudSampleSheetToStringReturnsExpectedResult(): void
    {
        $indexOrientation = IndexOrientation::FORWARD();

        $overrideCycles0 = OverrideCycles::fromString('R1:U7N1Y143;I1:I8;I2:I8;R2:U7N1Y143', $indexOrientation);

        $bclSample0 = new BclSample(
            new NovaSeqX1_5B([1]),
            'Sample1',
            'Index1',
            'Index2',
            $overrideCycles0,
            'Adapter1',
            'Adapter2',
            '0',
            '0'
        );

        $overrideCycles1 = OverrideCycles::fromString('R1:Y151;I1:I8;I2:I10;R2:Y151', $indexOrientation);
        $bclSample1 = new BclSample(
            new NovaSeqX1_5B([2]),
            'Sample2',
            'Index3',
            'Index4',
            $overrideCycles1,
            'Adapter3',
            'Adapter4',
            '0',
            '0'
        );

        $overrideCycles2 = OverrideCycles::fromString('R1:Y151;I1:I8;I2:I8;R2:U10N12Y127', $indexOrientation);
        $bclSample2 = new BclSample(
            new NovaSeqX1_5B(null),
            'Sample3',
            'Index5',
            'Index6',
            $overrideCycles2,
            'Adapter5',
            'Adapter6',
            '0',
            '0'
        );

        $overrideCycles3 = OverrideCycles::fromString('R1:Y101;I1:I8;I2:I8;R2:Y101', $indexOrientation);
        $bclSample3 = new BclSample(
            new NovaSeqX1_5B(null),
            'Sample4',
            'Index5',
            'Index6',
            $overrideCycles3,
            'Adapter5',
            'Adapter6',
            '1',
            '1'
        );

        $bclSampleList = new Collection([
            $bclSample0,
            $bclSample1,
            $bclSample2,
            $bclSample3,
        ]);

        $headerSection = new HeaderSection(
            'Run1',
            $indexOrientation,
            InstrumentPlatform::NOVASEQ_X_SERIES(),
            null
        );

        $bclConvertSettingsSection = new BclConvertSettingsSection(BclConvertSoftwareVersion::V4_1_23());

        $bclConvertDataSection = new BclConvertDataSection($bclSampleList);

        $readsSection = ReadsSection::fromOverrideCycleCounter($bclConvertDataSection->overrideCycleCounter);

        $sampleSheet = new IlluminaSampleSheetVersion2(
            $headerSection,
            $readsSection,
            $bclConvertSettingsSection,
            $bclConvertDataSection,
            new CloudSettingsSection(),
            new CloudDataSection(new Collection([
                new CloudDataItem($bclSample0->sampleID, 'test', 'foo'),
                new CloudDataItem($bclSample1->sampleID, 'test', 'foo'),
                new CloudDataItem($bclSample2->sampleID, 'test', 'foo'),
                new CloudDataItem($bclSample3->sampleID, 'test', 'foo'),
            ]))
        );

        $expected = '[Header]
FileFormatVersion,2
RunName,Run1
IndexOrientation,Forward
InstrumentPlatform,NovaSeqXSeries

[Reads]
Read1Cycles,151
Read2Cycles,151
Index1Cycles,8
Index2Cycles,10

[BCLConvert_Settings]
FastqCompressionFormat,gzip
GenerateFastqcMetrics,true
SoftwareVersion,4.1.23

[BCLConvert_Data]
Lane,Sample_ID,Index,Index2,OverrideCycles,AdapterRead1,AdapterRead2,BarcodeMismatchesIndex1,BarcodeMismatchesIndex2
1,Sample1,Index1,Index2,R1:U7N1Y143;I1:I8;I2:N2I8;R2:U7N1Y143,Adapter1,Adapter2,0,0
2,Sample2,Index3,Index4,R1:Y151;I1:I8;I2:I10;R2:Y151,Adapter3,Adapter4,0,0
1,Sample3,Index5,Index6,R1:Y151;I1:I8;I2:N2I8;R2:U10N12Y127N2,Adapter5,Adapter6,0,0
2,Sample3,Index5,Index6,R1:Y151;I1:I8;I2:N2I8;R2:U10N12Y127N2,Adapter5,Adapter6,0,0
1,Sample4,Index5,Index6,R1:Y101N50;I1:I8;I2:N2I8;R2:Y101N50,Adapter5,Adapter6,1,1
2,Sample4,Index5,Index6,R1:Y101N50;I1:I8;I2:N2I8;R2:Y101N50,Adapter5,Adapter6,1,1

[Cloud_Settings]
GeneratedVersion,2.6.0.202308300002
Cloud_Workflow,ica_workflow_1
BCLConvert_Pipeline,urn:ilmn:ica:pipeline:d5c7e407-d439-48c8-bce5-b7aec225f6a7#BclConvert_v4_1_23_patch1

[Cloud_Data]
Sample1,test,foo
Sample2,test,foo
Sample3,test,foo
Sample4,test,foo
';
        self::assertSame($expected, $sampleSheet->toString());
    }
}

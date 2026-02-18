<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclSample;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycleCounter;
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
        $indexOrientation = IndexOrientation::FORWARD;

        $overrideCycles0 = OverrideCycles::fromString('R1:U7N1Y143;I1:I8;I2:I8;R2:U7N1Y143', $indexOrientation);

        $bclSample0 = new BclSample(
            lanes: [1],
            sampleID: 'Sample1',
            indexRead1: 'Index1',
            indexRead2: 'Index2',
            overrideCycles: $overrideCycles0,
            adapterRead1: 'Adapter1',
            adapterRead2: 'Adapter2',
            barcodeMismatchesIndex1: '0',
            barcodeMismatchesIndex2: '0'
        );

        $overrideCycles1 = OverrideCycles::fromString('R1:Y151;I1:I8;I2:I10;R2:Y151', $indexOrientation);
        $bclSample1 = new BclSample(
            lanes: [2],
            sampleID: 'Sample2',
            indexRead1: 'Index3', indexRead2: 'Index4',
            overrideCycles: $overrideCycles1,
            adapterRead1: 'Adapter3',
            adapterRead2: 'Adapter4',
            barcodeMismatchesIndex1: '0',
            barcodeMismatchesIndex2: '0'
        );

        $overrideCycles2 = OverrideCycles::fromString('R1:Y151;I1:I8;I2:I8;R2:U10N12Y127', $indexOrientation);
        $bclSample2 = new BclSample(
            lanes: [1,2],
            sampleID: 'Sample3',
            indexRead1: 'Index5',
            indexRead2: 'Index6',
            overrideCycles: $overrideCycles2,
            adapterRead1: 'Adapter5',
            adapterRead2: 'Adapter6',
            barcodeMismatchesIndex1: '0',
            barcodeMismatchesIndex2: '0'
        );

        $overrideCycles3 = OverrideCycles::fromString('R1:Y101;I1:I8;I2:I8;R2:Y101', $indexOrientation);
        $bclSample3 = new BclSample(
            lanes: [7,8],
            sampleID: 'Sample4',
            indexRead1: 'Index5',
            indexRead2: 'Index6',
            overrideCycles: $overrideCycles3,
            adapterRead1: 'Adapter5',
            adapterRead2: 'Adapter6',
            barcodeMismatchesIndex1: '1',
            barcodeMismatchesIndex2: '1'
        );

        $bclSampleList = new Collection([
            $bclSample0,
            $bclSample1,
            $bclSample2,
            $bclSample3,
        ]);

        $headerSection = new HeaderSection(
            runName: 'Run1',
            indexOrientation: $indexOrientation,
            instrumentPlatform: InstrumentPlatform::NOVASEQ_X_SERIES,
            runDescription: null
        );

        $overrideCycleCounter = new OverrideCycleCounter(new Collection([
            $overrideCycles0,
            $overrideCycles1,
            $overrideCycles2,
            $overrideCycles3,
        ]));

        $readsSection = ReadsSection::fromOverrideCycleCounter($overrideCycleCounter);

        $bclConvertSettingsSection = new BclConvertSettingsSection(bclConvertSoftwareVersion: BclConvertSoftwareVersion::V4_1_23);

        $bclConvertDataSection = new BclConvertDataSection(
            dataRows: $bclSampleList,
            overrideCycleCounter: $overrideCycleCounter
        );

        $sampleSheet = new IlluminaSampleSheetVersion2(
            headerSection: $headerSection,
            readsSection: $readsSection,
            bclConvertSettingsSection: $bclConvertSettingsSection,
            bclConvertDataSection: $bclConvertDataSection,
            cloudSettingsSection: new CloudSettingsSection(),
            cloudDataSection: new CloudDataSection(new Collection([
                new CloudDataItem(bioSampleName: $bclSample0->sampleID, projectName: "test", libraryName: "foo"),
                new CloudDataItem(bioSampleName: $bclSample1->sampleID, projectName: "test", libraryName: "foo"),
                new CloudDataItem(bioSampleName: $bclSample2->sampleID, projectName: "test", libraryName: "foo"),
                new CloudDataItem(bioSampleName: $bclSample3->sampleID, projectName: "test", libraryName: "foo"),
            ])),
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
7,Sample4,Index5,Index6,R1:Y101N50;I1:I8;I2:N2I8;R2:Y101N50,Adapter5,Adapter6,1,1
8,Sample4,Index5,Index6,R1:Y101N50;I1:I8;I2:N2I8;R2:Y101N50,Adapter5,Adapter6,1,1

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

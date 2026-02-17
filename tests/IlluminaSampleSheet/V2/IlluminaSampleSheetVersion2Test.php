<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\V2\InstrumentPlatform;
use MLL\Utils\IlluminaSampleSheet\V2\MissingRequiredFieldException;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\BclConvertSettingsSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\CloudDataItem;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\CloudDataSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\CloudSettingsSection;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\HeaderSectionVersion2;
use PHPUnit\Framework\TestCase;

final class IlluminaSampleSheetVersion2Test extends TestCase
{
    public function testHeaderSectionVersion2ToStringReturnsExpectedResult(): void
    {
        $headerSection = new class extends HeaderSectionVersion2 {};
        $headerSection->setRunName('TestRun1');
        $headerSection->setInstrumentPlatform(InstrumentPlatform::NOVASEQ_X_SERIES);

        $expected = "[Header]\nFileFormatVersion,2\nIndexOrientation,Forward\nRunName,TestRun1\nInstrumentPlatform,NovaSeqXSeries";

        self::assertSame($expected, $headerSection->convertSectionToString());
    }

    public function testHeaderSectionVersion2WithCustomAttribute(): void
    {
        $headerSection = new class extends HeaderSectionVersion2 {};
        $headerSection->setRunName('TestRun1');
        $headerSection->setInstrumentPlatform(InstrumentPlatform::NOVASEQ_X_SERIES);
        $headerSection->setCustomAttribute('Custom_TestKey', 'TestValue');

        $expected = "[Header]\nFileFormatVersion,2\nIndexOrientation,Forward\nRunName,TestRun1\nInstrumentPlatform,NovaSeqXSeries\nCustom_TestKey,TestValue";

        self::assertSame($expected, $headerSection->convertSectionToString());
    }

    public function testHeaderSectionVersion2ThrowsOnMissingRunName(): void
    {
        $headerSection = new class extends HeaderSectionVersion2 {};
        $headerSection->setInstrumentPlatform(InstrumentPlatform::NOVASEQ_X_SERIES);

        $this->expectException(MissingRequiredFieldException::class);
        $this->expectExceptionMessage("Missing required field 'RunName'");
        $headerSection->convertSectionToString();
    }

    public function testHeaderSectionVersion2ThrowsOnMissingInstrumentPlatform(): void
    {
        $headerSection = new class extends HeaderSectionVersion2 {};
        $headerSection->setRunName('TestRun1');

        $this->expectException(MissingRequiredFieldException::class);
        $this->expectExceptionMessage("Missing required field 'InstrumentPlatform'");
        $headerSection->convertSectionToString();
    }

    public function testHeaderSectionVersion2SetInstrumentPlatformMiSeq(): void
    {
        $headerSection = new class extends HeaderSectionVersion2 {};
        $headerSection->setRunName('TestRun1');
        $headerSection->setInstrumentPlatform(InstrumentPlatform::MISEQ_I100_SERIES);

        self::assertStringContainsString('InstrumentPlatform,MiSeqi100Series', $headerSection->convertSectionToString());
    }

    public function testBclConvertSettingsSectionToStringReturnsExpectedResult(): void
    {
        $section = new BclConvertSettingsSection();

        $expected = "[BCLConvert_Settings]\nSoftwareVersion,4.1.23\nFastqCompressionFormat,gzip";

        self::assertSame($expected, $section->convertSectionToString());
    }

    public function testBclConvertSettingsSectionOverrideDefaultValue(): void
    {
        $section = new BclConvertSettingsSection();
        $section->setCustomAttribute('SoftwareVersion', '5.0.0');

        $expected = "[BCLConvert_Settings]\nSoftwareVersion,5.0.0\nFastqCompressionFormat,gzip";

        self::assertSame($expected, $section->convertSectionToString());
    }

    public function testBclConvertSettingsSectionWithAdditionalAttribute(): void
    {
        $section = new BclConvertSettingsSection();
        $section->setCustomAttribute('TrimUMI', '1');

        $expected = "[BCLConvert_Settings]\nSoftwareVersion,4.1.23\nFastqCompressionFormat,gzip\nTrimUMI,1";

        self::assertSame($expected, $section->convertSectionToString());
    }

    public function testCloudSettingsSectionToStringReturnsExpectedResult(): void
    {
        $section = new CloudSettingsSection();

        $expected = '[Cloud_Settings]' . "\n"
            . 'GeneratedVersion,2.6.0.202308300002' . "\n"
            . 'Cloud_Workflow,ica_workflow_1' . "\n"
            . 'BCLConvert_Pipeline,urn:ilmn:ica:pipeline:d5c7e407-d439-48c8-bce5-b7aec225f6a7#BclConvert_v4_1_23_patch1';

        self::assertSame($expected, $section->convertSectionToString());
    }

    public function testCloudSettingsSectionOverrideDefaultValue(): void
    {
        $section = new CloudSettingsSection();
        $section->setCustomAttribute('GeneratedVersion', '3.0.0');

        self::assertStringContainsString('GeneratedVersion,3.0.0', $section->convertSectionToString());
        self::assertStringNotContainsString('2.6.0.202308300002', $section->convertSectionToString());
    }

    public function testCloudDataItemToStringReturnsExpectedResult(): void
    {
        $item = new CloudDataItem('BioSample1', 'ProjectA', 'LibraryX');

        self::assertSame('BioSample1,ProjectA,LibraryX', $item->toString());
    }

    public function testCloudDataSectionToStringReturnsExpectedResult(): void
    {
        $items = new Collection([
            new CloudDataItem('BioSample1', 'ProjectA', 'Library1'),
            new CloudDataItem('BioSample2', 'ProjectA', 'Library2'),
        ]);
        $section = new CloudDataSection($items);

        $expected = "BioSample1,ProjectA,Library1\nBioSample2,ProjectA,Library2";

        self::assertSame($expected, $section->convertSectionToString());
    }

    public function testCloudDataSectionWithSingleItem(): void
    {
        $items = new Collection([
            new CloudDataItem('OnlySample', 'OnlyProject', 'OnlyLibrary'),
        ]);
        $section = new CloudDataSection($items);

        self::assertSame('OnlySample,OnlyProject,OnlyLibrary', $section->convertSectionToString());
    }

    public function testCloudDataSectionEmptyReturnsEmptyString(): void
    {
        $section = new CloudDataSection(new Collection());

        self::assertSame('', $section->convertSectionToString());
    }

    public function testMissingRequiredFieldExceptionMessage(): void
    {
        $exception = new MissingRequiredFieldException('TestField');

        self::assertSame(
            "Missing required field 'TestField', please check the array requiredFields",
            $exception->getMessage(),
        );
    }
}

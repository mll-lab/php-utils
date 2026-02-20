<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\V2\BclConvertSoftwareVersion;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\BclConvertSettingsSection;
use PHPUnit\Framework\TestCase;

final class BclConvertSettingsSectionTest extends TestCase
{
    public function testToStringWithSoftwareVersion(): void
    {
        $bclConvertSettingsSection = new BclConvertSettingsSection(
            BclConvertSoftwareVersion::V4_1_23()
        );

        $expected = <<<'CSV'
FastqCompressionFormat,gzip
GenerateFastqcMetrics,true
SoftwareVersion,4.1.23

CSV;
        self::assertSame($expected, $bclConvertSettingsSection->convertSectionToString());
    }

    public function testToStringWithoutSoftwareVersion(): void
    {
        $bclConvertSettingsSection = new BclConvertSettingsSection(null);

        $expected = <<<'CSV'
FastqCompressionFormat,gzip
GenerateFastqcMetrics,true

CSV;
        self::assertSame($expected, $bclConvertSettingsSection->convertSectionToString());
    }
}

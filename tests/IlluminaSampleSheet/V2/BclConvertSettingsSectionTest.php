<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\V2\Sections\BclConvertSettingsSection;
use PHPUnit\Framework\TestCase;

final class BclConvertSettingsSectionTest extends TestCase
{
    public function testToStringOnCloud(): void
    {
        $bclConvertSettingsSection = new BclConvertSettingsSection();
        $bclConvertSettingsSection->performAnalysisOnCloud();
        $expected = <<<'CSV'
FastqCompressionFormat,gzip
SoftwareVersion,4.1.23

CSV;
        self::assertSame($expected, $bclConvertSettingsSection->convertSectionToString());
    }

    public function testToStringLocal(): void
    {
        $bclConvertSettingsSection = new BclConvertSettingsSection();
        $bclConvertSettingsSection->performAnalysisLocal();

        $expected = <<<'CSV'
FastqCompressionFormat,gzip
GenerateFastqcMetrics,true

CSV;
        self::assertSame($expected, $bclConvertSettingsSection->convertSectionToString());
    }
}

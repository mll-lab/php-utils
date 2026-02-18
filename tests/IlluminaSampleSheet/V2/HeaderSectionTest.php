<?php declare(strict_types=1);

namespace IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;
use MLL\Utils\IlluminaSampleSheet\V2\InstrumentPlatform;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\HeaderSection;
use PHPUnit\Framework\TestCase;

final class HeaderSectionTest extends TestCase
{
    public function testToString(): void
    {
        $headerSection = new HeaderSection(
            runName: 'Test1234',
            indexOrientation: IndexOrientation::FORWARD,
            instrumentPlatform: InstrumentPlatform::NOVASEQ_X_SERIES,
            runDescription: null
        );

        $expected = <<<'CSV'
FileFormatVersion,2
RunName,Test1234
IndexOrientation,Forward
InstrumentPlatform,NovaSeqXSeries

CSV;
        self::assertSame($expected, $headerSection->convertSectionToString());
    }
}

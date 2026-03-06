<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\Drew;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\Drew\DrewBclConvertDataSection;
use MLL\Utils\IlluminaSampleSheet\Drew\DrewSample;
use MLL\Utils\IlluminaSampleSheet\Drew\DrewSampleSheet;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use PHPUnit\Framework\TestCase;

final class DrewSampleSheetTest extends TestCase
{
    public function testToStringReturnsExpectedResult(): void
    {
        $samples = new Collection([
            new DrewSample('Sample1', '700ngInput'),
            new DrewSample('Sample2', '700ngInput'),
            new DrewSample('Control1', '875ngInput'),
            new DrewSample('NTC', '0ngInput'),
        ]);

        $sampleSheet = new DrewSampleSheet(
            new DrewBclConvertDataSection($samples),
        );

        $expected = '[BCLConvert_Data]
Sample_Name,Description
Sample1,700ngInput
Sample2,700ngInput
Control1,875ngInput
NTC,0ngInput
';
        self::assertSame($expected, $sampleSheet->toString());
    }

    public function testThrowsOnEmptySamples(): void
    {
        $sampleSheet = new DrewSampleSheet(
            new DrewBclConvertDataSection(new Collection()),
        );

        $this->expectException(IlluminaSampleSheetException::class);
        $sampleSheet->toString();
    }
}

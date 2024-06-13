<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet;

use MLL\Utils\IlluminaSampleSheet\BaseSampleSheet;
use MLL\Utils\IlluminaSampleSheet\Section;
use PHPUnit\Framework\TestCase;

final class SampleSheetTest extends TestCase
{
    public function testSampleSheetToStringReturnsCorrectFormat(): void
    {
        $sectionMock1 = $this->createMock(Section::class);
        $sectionMock1->method('convertSectionToString')->willReturn('section1');

        $sectionMock2 = $this->createMock(Section::class);
        $sectionMock2->method('convertSectionToString')->willReturn('section2');

        $sampleSheet = $this->createPartialMock(BaseSampleSheet::class, []);
        $sampleSheet->addSection($sectionMock1);
        $sampleSheet->addSection($sectionMock2);

        self::assertSame("section1\nsection2", $sampleSheet->toString());
    }
}

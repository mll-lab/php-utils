<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet;

use MLL\Utils\IlluminaSampleSheet\SampleSheet;
use MLL\Utils\IlluminaSampleSheet\SectionInterface;
use PHPUnit\Framework\TestCase;

class SampleSheetTest extends TestCase
{
    public function testSampleSheetToStringReturnsCorrectFormat(): void
    {
        $sectionMock1 = $this->createMock(SectionInterface::class);
        $sectionMock1->method('toString')->willReturn('section1');

        $sectionMock2 = $this->createMock(SectionInterface::class);
        $sectionMock2->method('toString')->willReturn('section2');

        $sampleSheet = $this->createPartialMock(SampleSheet::class, []);
        $sampleSheet->addSection($sectionMock1);
        $sampleSheet->addSection($sectionMock2);

        self::assertSame("section1\nsection2", $sampleSheet->toString());
    }
}

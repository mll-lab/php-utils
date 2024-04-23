<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\SectionedMicroplate;

use MLL\Utils\Microplate\CoordinateSystem96Well;
use MLL\Utils\Microplate\Section;
use MLL\Utils\Microplate\SectionedMicroplate;
use PHPUnit\Framework\TestCase;

final class SectionedMicroplateTest extends TestCase
{
    public function testCanAddSectionsAndWellsToSectionAndRemoveSections(): void
    {
        $coordinateSystem = new CoordinateSystem96Well();
        $sectionedMicroplate = new SectionedMicroplate($coordinateSystem);
        self::assertCount(0, $sectionedMicroplate->sections);

        $section1 = $sectionedMicroplate->addSection(Section::class);
        self::assertCount(1, $sectionedMicroplate->sections);

        $section2 = $sectionedMicroplate->addSection(Section::class);
        self::assertCount(2, $sectionedMicroplate->sections);

        self::assertCount(0, $sectionedMicroplate->filledWells());
        self::assertCount(96, $sectionedMicroplate->freeWells());

        $content1 = 'content1';
        $section1->addWell($content1);
        $content2 = 'content2';
        $content3 = 'content3';
        $section2->addWell($content2);
        $section2->addWell($content3);

        self::assertCount(3, $sectionedMicroplate->filledWells());
        self::assertCount(93, $sectionedMicroplate->freeWells());

        self::assertSame($content1, $section1->sectionItems->first());

        self::assertSame($content2, $section2->sectionItems->first());
        self::assertSame($content3, $section2->sectionItems->last());

        $sectionedMicroplate->removeSection($section1);
        self::assertCount(1, $sectionedMicroplate->sections);

        self::assertCount(2, $sectionedMicroplate->filledWells());
        self::assertCount(94, $sectionedMicroplate->freeWells());
    }
}

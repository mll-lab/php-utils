<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\SectionedMicroplate;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\Exceptions\MicroplateIsFullException;
use MLL\Utils\Microplate\Exceptions\SectionIsFullException;
use MLL\Utils\Microplate\FullColumnSection;
use MLL\Utils\Microplate\SectionedMicroplate;
use PHPUnit\Framework\TestCase;

final class FullColumnSectionTest extends TestCase
{
    public function testFullColumnSectionThrowsWhenFull(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $sectionedMicroplate = new SectionedMicroplate($coordinateSystem);
        self::assertCount(0, $sectionedMicroplate->sections);

        $section = $sectionedMicroplate->addSection(FullColumnSection::class);
        self::assertCount(1, $sectionedMicroplate->sections);
        self::assertCount(96, $sectionedMicroplate->freeWells());

        foreach ($coordinateSystem->all() as $i => $coordinate) {
            $section->addWell('column' . $i);
            self::assertCount($i + 1, $sectionedMicroplate->filledWells());
        }

        self::assertCount(0, $sectionedMicroplate->freeWells());
        $this->expectExceptionObject(new MicroplateIsFullException());

        $section->addWell('foo');
    }

    public function testCanNotAddFullColumnSectionIfAllColumnsAreReserved(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $sectionedMicroplate = new SectionedMicroplate($coordinateSystem);

        foreach (range(1, $coordinateSystem->columnsCount()) as $i) {
            $sectionedMicroplate->addSection(FullColumnSection::class);
        }

        $this->expectExceptionObject(new SectionIsFullException());
        $sectionedMicroplate->addSection(FullColumnSection::class);
    }

    public function testCanNotGrowFullColumnSectionIfNoColumnsAreLeft(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $sectionedMicroplate = new SectionedMicroplate($coordinateSystem);

        foreach (range(1, $coordinateSystem->columnsCount() - 1) as $i) {
            $sectionedMicroplate->addSection(FullColumnSection::class);
        }

        $lastSection = $sectionedMicroplate->addSection(FullColumnSection::class);
        foreach (range(1, $coordinateSystem->rowsCount()) as $i) {
            $lastSection->addWell('foo');
        }

        $this->expectExceptionObject(new SectionIsFullException());
        $lastSection->addWell('bar');
    }

    public function testFullColumnSection(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $sectionedMicroplate = new SectionedMicroplate($coordinateSystem);
        self::assertCount(0, $sectionedMicroplate->sections);

        $section1 = $sectionedMicroplate->addSection(FullColumnSection::class);
        self::assertCount(1, $sectionedMicroplate->sections);
        self::assertCount(96, $sectionedMicroplate->freeWells());

        foreach (range(1, 4) as $ignored1) {
            $section1->addWell('section1');
        }

        $section2 = $sectionedMicroplate->addSection(FullColumnSection::class);
        $emptyCoordinateInSection1 = new Coordinates('E', 1, $coordinateSystem);
        self::assertNull($sectionedMicroplate->well($emptyCoordinateInSection1));

        foreach (range(1, 5) as $ignored1) {
            $section2->addWell('section2');
        }
        self::assertNull($sectionedMicroplate->well($emptyCoordinateInSection1));

        self::assertSame([
            'A1' => 'section1',
            'B1' => 'section1',
            'C1' => 'section1',
            'D1' => 'section1',
            'A2' => 'section2',
            'B2' => 'section2',
            'C2' => 'section2',
            'D2' => 'section2',
            'E2' => 'section2',
        ], $sectionedMicroplate->filledWells()->toArray());

        foreach (range(1, 16) as $ignored1) {
            $section1->addWell('section1');
        }

        self::assertSame([
            'A1' => 'section1',
            'B1' => 'section1',
            'C1' => 'section1',
            'D1' => 'section1',
            'E1' => 'section1',
            'F1' => 'section1',
            'G1' => 'section1',
            'H1' => 'section1',
            'A2' => 'section1',
            'B2' => 'section1',
            'C2' => 'section1',
            'D2' => 'section1',
            'E2' => 'section1',
            'F2' => 'section1',
            'G2' => 'section1',
            'H2' => 'section1',
            'A3' => 'section1',
            'B3' => 'section1',
            'C3' => 'section1',
            'D3' => 'section1',
            'A4' => 'section2',
            'B4' => 'section2',
            'C4' => 'section2',
            'D4' => 'section2',
            'E4' => 'section2',
        ], $sectionedMicroplate->filledWells()->toArray());

        $this->expectExceptionObject(new SectionIsFullException());

        foreach (range(1, 100) as $ignored1) {
            $section1->addWell('section1');
        }
    }
}

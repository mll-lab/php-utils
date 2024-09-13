<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\SectionedMicroplate;

use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\Exceptions\MicroplateIsFullException;
use MLL\Utils\Microplate\Section;
use MLL\Utils\Microplate\SectionedMicroplate;
use PHPUnit\Framework\TestCase;

final class SectionTest extends TestCase
{
    public function testSectionThrowsWhenFull(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $sectionedMicroplate = new SectionedMicroplate($coordinateSystem);
        self::assertCount(0, $sectionedMicroplate->sections);

        $section = $sectionedMicroplate->addSection(Section::class);
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
}

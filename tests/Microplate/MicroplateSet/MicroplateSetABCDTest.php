<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\MicroplateSet;

use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\CoordinateSystem4x3;
use MLL\Utils\Microplate\Enums\FlowDirection;
use MLL\Utils\Microplate\MicroplateSet\MicroplateSetABCD;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MicroplateSetABCDTest extends TestCase
{
    public function testSetLocationFromSetPositionFor12x8lPlatesOutOfRangeTooHigh(): void
    {
        $microplateSet = new MicroplateSetABCD(new CoordinateSystem12x8());

        $setPositionHigherThanMax = 385;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-384, got: {$setPositionHigherThanMax}"));
        $microplateSet->locationFromPosition($setPositionHigherThanMax, FlowDirection::COLUMN());
    }

    public function testSetLocationFromSetPositionFor12x8PlatesOutOfRangeTooLow(): void
    {
        $microplateSet = new MicroplateSetABCD(new CoordinateSystem12x8());

        $setPositionLowerThanMin = 0;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-384, got: {$setPositionLowerThanMin}"));
        $microplateSet->locationFromPosition($setPositionLowerThanMin, FlowDirection::COLUMN());
    }

    public function testSetLocationFromSetPositionFor12WellPlatesOutOfRangeTooHigh(): void
    {
        $microplateSet = new MicroplateSetABCD(new CoordinateSystem4x3());

        $setPositionHigherThanMax = 49;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-48, got: {$setPositionHigherThanMax}"));
        $microplateSet->locationFromPosition($setPositionHigherThanMax, FlowDirection::COLUMN());
    }

    public function testSetLocationFromSetPositionFor12WellPlatesOutOfRangeTooLow(): void
    {
        $microplateSet = new MicroplateSetABCD(new CoordinateSystem4x3());

        $setPositionLowerThanMin = 0;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-48, got: {$setPositionLowerThanMin}"));
        $microplateSet->locationFromPosition($setPositionLowerThanMin, FlowDirection::COLUMN());
    }

    #[DataProvider('dataProvider12Well')]
    public function testSetLocationFromSetPositionFor12Wells(int $position, string $coordinatesString, string $plateID): void
    {
        $microplateSet = new MicroplateSetABCD(new CoordinateSystem4x3());

        $location = $microplateSet->locationFromPosition($position, FlowDirection::COLUMN());
        self::assertSame($location->coordinates->toString(), $coordinatesString);
        self::assertSame($location->plateID, $plateID);
    }

    /** @return iterable<array{position: int, coordinatesString: string, plateID: string}> */
    public static function dataProvider12Well(): iterable
    {
        yield [
            'position' => 1,
            'coordinatesString' => 'A1',
            'plateID' => 'A',
        ];
        yield [
            'position' => 2,
            'coordinatesString' => 'B1',
            'plateID' => 'A',
        ];
        yield [
            'position' => 3,
            'coordinatesString' => 'C1',
            'plateID' => 'A',
        ];
        yield [
            'position' => 12,
            'coordinatesString' => 'C4',
            'plateID' => 'A',
        ];
        yield [
            'position' => 13,
            'coordinatesString' => 'A1',
            'plateID' => 'B',
        ];
        yield [
            'position' => 48,
            'coordinatesString' => 'C4',
            'plateID' => 'D',
        ];
    }

    #[DataProvider('dataProvider12x8')]
    public function testSetLocationFromSetPositionFor12x8(int $position, string $coordinatesString, string $plateID): void
    {
        $microplateSet = new MicroplateSetABCD(new CoordinateSystem12x8());

        $location = $microplateSet->locationFromPosition($position, FlowDirection::COLUMN());
        self::assertSame($coordinatesString, $location->coordinates->toString());
        self::assertSame($plateID, $location->plateID);
    }

    /** @return iterable<array{position: int, coordinatesString: string, plateID: string}> */
    public static function dataProvider12x8(): iterable
    {
        yield [
            'position' => 1,
            'coordinatesString' => 'A1',
            'plateID' => 'A',
        ];
        yield [
            'position' => 2,
            'coordinatesString' => 'B1',
            'plateID' => 'A',
        ];
        yield [
            'position' => 3,
            'coordinatesString' => 'C1',
            'plateID' => 'A',
        ];
        yield [
            'position' => 12,
            'coordinatesString' => 'D2',
            'plateID' => 'A',
        ];
        yield [
            'position' => 13,
            'coordinatesString' => 'E2',
            'plateID' => 'A',
        ];
        yield [
            'position' => 96,
            'coordinatesString' => 'H12',
            'plateID' => 'A',
        ];
        yield [
            'position' => 97,
            'coordinatesString' => 'A1',
            'plateID' => 'B',
        ];
        yield [
            'position' => 384,
            'coordinatesString' => 'H12',
            'plateID' => 'D',
        ];
        yield [
            'position' => 383,
            'coordinatesString' => 'G12',
            'plateID' => 'D',
        ];
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\MicroplateSet;

use MLL\Utils\Microplate\CoordinateSystem12Well;
use MLL\Utils\Microplate\CoordinateSystem96Well;
use MLL\Utils\Microplate\Enums\FlowDirection;
use MLL\Utils\Microplate\MicroplateSet\MicroplateSetAB;
use PHPUnit\Framework\TestCase;

final class MicroplateSetABTest extends TestCase
{
    public function testSetLocationFromSetPositionFor96WellPlatesOutOfRangeTooHigh(): void
    {
        $microplateSet = new MicroplateSetAB(new CoordinateSystem96Well());

        $setPositionHigherThanMax = 193;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-192, got: {$setPositionHigherThanMax}"));
        $microplateSet->locationFromPosition($setPositionHigherThanMax, FlowDirection::COLUMN());
    }

    public function testSetLocationFromSetPositionFor96WellPlatesOutOfRangeTooLow(): void
    {
        $microplateSet = new MicroplateSetAB(new CoordinateSystem96Well());

        $setPositionLowerThanMin = 0;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-192, got: {$setPositionLowerThanMin}"));
        $microplateSet->locationFromPosition($setPositionLowerThanMin, FlowDirection::COLUMN());
    }

    public function testSetLocationFromSetPositionFor12WellPlatesOutOfRangeTooHigh(): void
    {
        $microplateSet = new MicroplateSetAB(new CoordinateSystem12Well());

        $setPositionHigherThanMax = 25;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-24, got: {$setPositionHigherThanMax}"));
        $microplateSet->locationFromPosition($setPositionHigherThanMax, FlowDirection::COLUMN());
    }

    public function testSetLocationFromSetPositionFor12WellPlatesOutOfRangeTooLow(): void
    {
        $microplateSet = new MicroplateSetAB(new CoordinateSystem12Well());

        $setPositionLowerThanMin = 0;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-24, got: {$setPositionLowerThanMin}"));
        $microplateSet->locationFromPosition($setPositionLowerThanMin, FlowDirection::COLUMN());
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider12Well')]
    public function testSetLocationFromSetPositionFor12Wells(int $position, string $coordinatesString, string $plateID): void
    {
        $microplateSet = new MicroplateSetAB(new CoordinateSystem12Well());

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
            'position' => 24,
            'coordinatesString' => 'C4',
            'plateID' => 'B',
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider96Well')]
    public function testSetLocationFromSetPositionFor96Wells(int $position, string $coordinatesString, string $plateID): void
    {
        $microplateSet = new MicroplateSetAB(new CoordinateSystem96Well());

        $location = $microplateSet->locationFromPosition($position, FlowDirection::COLUMN());
        self::assertSame($coordinatesString, $location->coordinates->toString());
        self::assertSame($plateID, $location->plateID);
    }

    /**
     * @return iterable<array{
     *   position: int,
     *   coordinatesString: string,
     *   plateID: string,
     * }>
     */
    public static function dataProvider96Well(): iterable
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
            'position' => 192,
            'coordinatesString' => 'H12',
            'plateID' => 'B',
        ];
        yield [
            'position' => 191,
            'coordinatesString' => 'G12',
            'plateID' => 'B',
        ];
    }
}

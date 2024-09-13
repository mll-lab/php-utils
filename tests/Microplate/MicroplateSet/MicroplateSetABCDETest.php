<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate\MicroplateSet;

use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\CoordinateSystem4x3;
use MLL\Utils\Microplate\Enums\FlowDirection;
use MLL\Utils\Microplate\MicroplateSet\MicroplateSetABCDE;
use PHPUnit\Framework\TestCase;

final class MicroplateSetABCDETest extends TestCase
{
    public function testSetLocationFromSetPositionFor12x8PlatesOutOfRangeTooHigh(): void
    {
        $microplateSet = new MicroplateSetABCDE(new CoordinateSystem12x8());

        $setPositionHigherThanMax = 481;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-480, got: {$setPositionHigherThanMax}"));
        $microplateSet->locationFromPosition($setPositionHigherThanMax, FlowDirection::COLUMN());
    }

    public function testSetLocationFromSetPositionFor12x8PlatesOutOfRangeTooLow(): void
    {
        $microplateSet = new MicroplateSetABCDE(new CoordinateSystem12x8());

        $setPositionLowerThanMin = 0;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-480, got: {$setPositionLowerThanMin}"));
        $microplateSet->locationFromPosition($setPositionLowerThanMin, FlowDirection::COLUMN());
    }

    public function testSetLocationFromSetPositionFor12WellPlatesOutOfRangeTooHigh(): void
    {
        $microplateSet = new MicroplateSetABCDE(new CoordinateSystem4x3());

        $setPositionHigherThanMax = 61;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-60, got: {$setPositionHigherThanMax}"));
        $microplateSet->locationFromPosition($setPositionHigherThanMax, FlowDirection::COLUMN());
    }

    public function testSetLocationFromSetPositionFor12WellPlatesOutOfRangeTooLow(): void
    {
        $microplateSet = new MicroplateSetABCDE(new CoordinateSystem4x3());

        $setPositionLowerThanMin = 0;
        self::expectExceptionObject(new \OutOfRangeException("Expected a position between 1-60, got: {$setPositionLowerThanMin}"));
        $microplateSet->locationFromPosition($setPositionLowerThanMin, FlowDirection::COLUMN());
    }
}

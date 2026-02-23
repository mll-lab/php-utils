<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\CoordinateSystem1x1;
use MLL\Utils\Microplate\CoordinateSystem2x16;
use MLL\Utils\Microplate\CoordinateSystem2x16NoJ;
use MLL\Utils\Microplate\CoordinateSystem4x3;
use MLL\Utils\Microplate\CoordinateSystem6x4;
use MLL\Utils\Microplate\CoordinateSystem6x8;
use MLL\Utils\Microplate\CoordinateSystem8x6;
use MLL\Utils\Microplate\Enums\FlowDirection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class NonAdjacentPositionsTest extends TestCase
{
    /** @dataProvider countProvider */
    #[DataProvider('countProvider')]
    public function testCount(CoordinateSystem $coordinateSystem, int $expectedCount): void
    {
        $columnPositions = $coordinateSystem->nonAdjacentPositions(FlowDirection::COLUMN());
        self::assertCount($expectedCount, $columnPositions);

        $rowPositions = $coordinateSystem->nonAdjacentPositions(FlowDirection::ROW());
        self::assertCount($expectedCount, $rowPositions);
    }

    /** @return iterable<array{CoordinateSystem, int}> */
    public static function countProvider(): iterable
    {
        yield '12x8' => [new CoordinateSystem12x8(), 48];
        yield '6x8' => [new CoordinateSystem6x8(), 24];
        yield '4x3' => [new CoordinateSystem4x3(), 6];
        yield '1x1' => [new CoordinateSystem1x1(), 1];
        yield '8x6' => [new CoordinateSystem8x6(), 24];
        yield '6x4' => [new CoordinateSystem6x4(), 12];
        yield '2x16' => [new CoordinateSystem2x16(), 16];
        yield '2x16NoJ' => [new CoordinateSystem2x16NoJ(), 16];
    }

    /** @dataProvider countFormulaProvider */
    #[DataProvider('countFormulaProvider')]
    public function testCountIsCeilOfHalfPositions(CoordinateSystem $coordinateSystem): void
    {
        $positions = $coordinateSystem->nonAdjacentPositions(FlowDirection::COLUMN());
        $expected = (int) ceil($coordinateSystem->positionsCount() / 2);

        self::assertCount($expected, $positions);
    }

    /** @return iterable<array{CoordinateSystem}> */
    public static function countFormulaProvider(): iterable
    {
        yield '12x8' => [new CoordinateSystem12x8()];
        yield '6x8' => [new CoordinateSystem6x8()];
        yield '4x3' => [new CoordinateSystem4x3()];
        yield '1x1' => [new CoordinateSystem1x1()];
        yield '8x6' => [new CoordinateSystem8x6()];
        yield '6x4' => [new CoordinateSystem6x4()];
        yield '2x16' => [new CoordinateSystem2x16()];
        yield '2x16NoJ' => [new CoordinateSystem2x16NoJ()];
    }

    public function testColumnFlowOrder(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $positions = $coordinateSystem->nonAdjacentPositions(FlowDirection::COLUMN());

        $firstFour = array_map(
            static fn (Coordinates $coordinates): string => $coordinates->toString(),
            array_slice($positions, 0, 4),
        );

        self::assertSame(['A1', 'C1', 'E1', 'G1'], $firstFour);
    }

    public function testRowFlowOrder(): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $positions = $coordinateSystem->nonAdjacentPositions(FlowDirection::ROW());

        $firstSix = array_map(
            static fn (Coordinates $coordinates): string => $coordinates->toString(),
            array_slice($positions, 0, 6),
        );

        self::assertSame(['A1', 'A3', 'A5', 'A7', 'A9', 'A11'], $firstSix);
    }

    /** @dataProvider flowDirectionProvider */
    #[DataProvider('flowDirectionProvider')]
    public function testNoDuplicates(FlowDirection $flowDirection): void
    {
        $coordinateSystem = new CoordinateSystem12x8();
        $positions = $coordinateSystem->nonAdjacentPositions($flowDirection);

        $strings = array_map(
            static fn (Coordinates $coordinates): string => $coordinates->toString(),
            $positions,
        );

        self::assertSame($strings, array_unique($strings));
    }

    /** @dataProvider allCoordinateSystemsAndDirectionsProvider */
    #[DataProvider('allCoordinateSystemsAndDirectionsProvider')]
    public function testAllSatisfyNonAdjacentInvariant(CoordinateSystem $coordinateSystem, FlowDirection $flowDirection): void
    {
        $positions = $coordinateSystem->nonAdjacentPositions($flowDirection);
        $rows = $coordinateSystem->rows();
        $columns = $coordinateSystem->columns();

        foreach ($positions as $coordinate) {
            $rowIndex = array_search($coordinate->row, $rows, true);
            assert(is_int($rowIndex));

            $columnIndex = array_search($coordinate->column, $columns, true);
            assert(is_int($columnIndex));

            self::assertSame(
                0,
                ($columnIndex + $rowIndex) % 2,
                "Coordinate {$coordinate->toString()} does not satisfy (columnIndex + rowIndex) % 2 === 0",
            );
        }
    }

    /** @dataProvider countFormulaProvider */
    #[DataProvider('countFormulaProvider')]
    public function testBothFlowDirectionsProduceSameSet(CoordinateSystem $coordinateSystem): void
    {
        $columnPositions = $coordinateSystem->nonAdjacentPositions(FlowDirection::COLUMN());
        $rowPositions = $coordinateSystem->nonAdjacentPositions(FlowDirection::ROW());

        $columnStrings = array_map(static fn (Coordinates $coordinates): string => $coordinates->toString(), $columnPositions);
        $rowStrings = array_map(static fn (Coordinates $coordinates): string => $coordinates->toString(), $rowPositions);

        self::assertEqualsCanonicalizing($columnStrings, $rowStrings);
    }

    public function test1x1ReturnsA1(): void
    {
        $coordinateSystem = new CoordinateSystem1x1();

        $columnPositions = $coordinateSystem->nonAdjacentPositions(FlowDirection::COLUMN());
        self::assertCount(1, $columnPositions);
        self::assertSame('A1', $columnPositions[0]->toString());

        $rowPositions = $coordinateSystem->nonAdjacentPositions(FlowDirection::ROW());
        self::assertCount(1, $rowPositions);
        self::assertSame('A1', $rowPositions[0]->toString());
    }

    /** @return iterable<array{FlowDirection}> */
    public static function flowDirectionProvider(): iterable
    {
        yield 'COLUMN' => [FlowDirection::COLUMN()];
        yield 'ROW' => [FlowDirection::ROW()];
    }

    /** @return iterable<array{CoordinateSystem, FlowDirection}> */
    public static function allCoordinateSystemsAndDirectionsProvider(): iterable
    {
        $systems = [
            '12x8' => new CoordinateSystem12x8(),
            '6x8' => new CoordinateSystem6x8(),
            '4x3' => new CoordinateSystem4x3(),
            '1x1' => new CoordinateSystem1x1(),
            '8x6' => new CoordinateSystem8x6(),
            '6x4' => new CoordinateSystem6x4(),
            '2x16' => new CoordinateSystem2x16(),
            '2x16NoJ' => new CoordinateSystem2x16NoJ(),
        ];

        foreach ($systems as $name => $system) {
            yield "{$name} COLUMN" => [$system, FlowDirection::COLUMN()];
            yield "{$name} ROW" => [$system, FlowDirection::ROW()];
        }
    }
}

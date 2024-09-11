<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem;
use MLL\Utils\Microplate\CoordinateSystem12Well;
use MLL\Utils\Microplate\CoordinateSystem2x16Well;
use MLL\Utils\Microplate\CoordinateSystem96Well;
use MLL\Utils\Microplate\Enums\FlowDirection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CoordinatesTest extends TestCase
{
    /** @dataProvider dataProviderWells */
    #[DataProvider('dataProviderWells')]
    public function testCanConstructFromRowAndColumn(CoordinateSystem $coordinateSystem, array $wells): void
    {
        foreach ($wells as $well) {
            $coordinates = new Coordinates($well['row'], $well['column'], $coordinateSystem);
            self::assertSame($well['row'] . $well['column'], $coordinates->toString());
        }
    }

    /** @dataProvider dataProviderWells */
    #[DataProvider('dataProviderWells')]
    public function testCanConstructFromPosition(CoordinateSystem $coordinateSystem, array $wells): void
    {
        foreach ($wells as $well) {
            // test for Column-FlowDirection
            $coordinates = Coordinates::fromPosition(
                $well['columnFlowPosition'],
                FlowDirection::COLUMN(),
                $coordinateSystem
            );
            self::assertSame($well['row'], $coordinates->row);
            self::assertSame($well['column'], $coordinates->column);

            // test for Row-FlowDirection
            $coordinates = Coordinates::fromPosition(
                $well['rowFlowPosition'],
                FlowDirection::ROW(),
                $coordinateSystem
            );
            self::assertSame($well['row'], $coordinates->row);
            self::assertSame($well['column'], $coordinates->column);
        }

    }

    /** @dataProvider dataProviderWells */
    #[DataProvider('dataProviderWells')]
    public function testFromCoordinatesString(CoordinateSystem $coordinateSystem, array $wells): void
    {
        foreach ($wells as $well) {
            $coordinates = Coordinates::fromString($well['row'] . $well['column'], $coordinateSystem);
            self::assertSame($well['row'], $coordinates->row);
            self::assertSame($well['column'], $coordinates->column);
        }
    }

    /** @dataProvider dataProviderPaddedWells */
    #[DataProvider('dataProviderPaddedWells')]
    public function testFromPaddedCoordinatesString(CoordinateSystem $coordinateSystem, array $paddedWells): void
    {
        foreach ($paddedWells as $paddedWell) {
            var_dump($paddedWell);
            $coordinatesFromPadded = Coordinates::fromString($paddedWell['paddedCoordinates'], $coordinateSystem);
            self::assertSame($paddedWell['row'], $coordinatesFromPadded->row);
            self::assertSame($paddedWell['column'], $coordinatesFromPadded->column);
            self::assertSame($paddedWell['paddedCoordinates'], $coordinatesFromPadded->toPaddedString());
        }
    }

    /** @dataProvider dataProviderWells */
    #[DataProvider('dataProviderWells')]
    public function testPosition96Well(CoordinateSystem $coordinateSystem, array $wells): void
    {
        foreach ($wells as $well) {
            $coordinates = new Coordinates($well['row'], $well['column'], $coordinateSystem);
            self::assertSame($well['columnFlowPosition'], $coordinates->position(FlowDirection::COLUMN()));
            self::assertSame($well['rowFlowPosition'], $coordinates->position(FlowDirection::ROW()));
        }
    }

    public static function dataProviderPaddedWells(): array
    {
        return [
            '96Wells' => [ new CoordinateSystem96Well(), [
                ['paddedCoordinates' => 'A01', 'row' => 'A', 'column' => 1,],
                ['paddedCoordinates' => 'C05','row' => 'C','column' => 5,],
                ['paddedCoordinates' => 'H12', 'row' => 'H', 'column' => 12,],
                ['paddedCoordinates' => 'D10','row' => 'D','column' => 10,],
            ],],
            '2x16Wells' => [ new CoordinateSystem2x16Well(), [
                ['paddedCoordinates' => 'A1', 'row' => 'A', 'column' => 1,],
                ['paddedCoordinates' => 'B2','row' => 'B','column' => 2,],
                ['paddedCoordinates' => 'M1', 'row' => 'M', 'column' => 1,],
                ['paddedCoordinates' => 'K2','row' => 'K','column' => 2,],
            ],],
        ];
    }

    public static function dataProviderWells(): array
    {
        return [
            '96Wells' => [ new CoordinateSystem96Well(), self::data96Wells(),],
            '2x16Wells' => [ new CoordinateSystem2x16Well(), self::data2x16Wells(),],
        ];
    }

    /**
     * @return array<array{
     *   row: string,
     *   column: int,
     *   rowFlowPosition: int,
     *   columnFlowPosition: int,
     * }>
     */
    public static function data96Wells(): array
    {
        return [
            [ 'row' => 'A', 'column' => 1, 'rowFlowPosition' => 1, 'columnFlowPosition' => 1,],
            [ 'row' => 'B', 'column' => 1, 'rowFlowPosition' => 13, 'columnFlowPosition' => 2,],
            [ 'row' => 'C', 'column' => 1, 'rowFlowPosition' => 25, 'columnFlowPosition' => 3,],
            [ 'row' => 'D', 'column' => 1, 'rowFlowPosition' => 37, 'columnFlowPosition' => 4,],
            [ 'row' => 'E', 'column' => 1, 'rowFlowPosition' => 49, 'columnFlowPosition' => 5,],
            [ 'row' => 'F', 'column' => 1, 'rowFlowPosition' => 61, 'columnFlowPosition' => 6,],
            [ 'row' => 'G', 'column' => 1, 'rowFlowPosition' => 73, 'columnFlowPosition' => 7,],
            [ 'row' => 'H', 'column' => 1, 'rowFlowPosition' => 85, 'columnFlowPosition' => 8,],
            [ 'row' => 'A', 'column' => 2, 'rowFlowPosition' => 2, 'columnFlowPosition' => 9,],
            [ 'row' => 'B', 'column' => 2, 'rowFlowPosition' => 14, 'columnFlowPosition' => 10,],
            [ 'row' => 'C', 'column' => 2, 'rowFlowPosition' => 26, 'columnFlowPosition' => 11,],
            [ 'row' => 'D', 'column' => 2, 'rowFlowPosition' => 38, 'columnFlowPosition' => 12,],
            [ 'row' => 'E', 'column' => 2, 'rowFlowPosition' => 50, 'columnFlowPosition' => 13,],
            [ 'row' => 'F', 'column' => 2, 'rowFlowPosition' => 62, 'columnFlowPosition' => 14,],
            [ 'row' => 'G', 'column' => 2, 'rowFlowPosition' => 74, 'columnFlowPosition' => 15,],
            [ 'row' => 'H', 'column' => 2, 'rowFlowPosition' => 86, 'columnFlowPosition' => 16,],
            [ 'row' => 'A', 'column' => 3, 'rowFlowPosition' => 3, 'columnFlowPosition' => 17,],
            [ 'row' => 'B', 'column' => 3, 'rowFlowPosition' => 15, 'columnFlowPosition' => 18,],
            [ 'row' => 'C', 'column' => 3, 'rowFlowPosition' => 27, 'columnFlowPosition' => 19,],
            [ 'row' => 'D', 'column' => 3, 'rowFlowPosition' => 39, 'columnFlowPosition' => 20,],
            [ 'row' => 'E', 'column' => 3, 'rowFlowPosition' => 51, 'columnFlowPosition' => 21,],
            [ 'row' => 'F', 'column' => 3, 'rowFlowPosition' => 63, 'columnFlowPosition' => 22,],
            [ 'row' => 'G', 'column' => 3, 'rowFlowPosition' => 75, 'columnFlowPosition' => 23,],
            [ 'row' => 'H', 'column' => 3, 'rowFlowPosition' => 87, 'columnFlowPosition' => 24,],
            [ 'row' => 'A', 'column' => 4, 'rowFlowPosition' => 4, 'columnFlowPosition' => 25,],
            [ 'row' => 'B', 'column' => 4, 'rowFlowPosition' => 16, 'columnFlowPosition' => 26,],
            [ 'row' => 'C', 'column' => 4, 'rowFlowPosition' => 28, 'columnFlowPosition' => 27,],
            [ 'row' => 'D', 'column' => 4, 'rowFlowPosition' => 40, 'columnFlowPosition' => 28,],
            [ 'row' => 'E', 'column' => 4, 'rowFlowPosition' => 52, 'columnFlowPosition' => 29,],
            [ 'row' => 'F', 'column' => 4, 'rowFlowPosition' => 64, 'columnFlowPosition' => 30,],
            [ 'row' => 'G', 'column' => 4, 'rowFlowPosition' => 76, 'columnFlowPosition' => 31,],
            [ 'row' => 'H', 'column' => 4, 'rowFlowPosition' => 88, 'columnFlowPosition' => 32,],
            [ 'row' => 'A', 'column' => 5, 'rowFlowPosition' => 5, 'columnFlowPosition' => 33,],
            [ 'row' => 'B', 'column' => 5, 'rowFlowPosition' => 17, 'columnFlowPosition' => 34,],
            [ 'row' => 'C', 'column' => 5, 'rowFlowPosition' => 29, 'columnFlowPosition' => 35,],
            [ 'row' => 'D', 'column' => 5, 'rowFlowPosition' => 41, 'columnFlowPosition' => 36,],
            [ 'row' => 'E', 'column' => 5, 'rowFlowPosition' => 53, 'columnFlowPosition' => 37,],
            [ 'row' => 'F', 'column' => 5, 'rowFlowPosition' => 65, 'columnFlowPosition' => 38,],
            [ 'row' => 'G', 'column' => 5, 'rowFlowPosition' => 77, 'columnFlowPosition' => 39,],
            [ 'row' => 'H', 'column' => 5, 'rowFlowPosition' => 89, 'columnFlowPosition' => 40,],
            [ 'row' => 'A', 'column' => 6, 'rowFlowPosition' => 6, 'columnFlowPosition' => 41,],
            [ 'row' => 'B', 'column' => 6, 'rowFlowPosition' => 18, 'columnFlowPosition' => 42,],
            [ 'row' => 'C', 'column' => 6, 'rowFlowPosition' => 30, 'columnFlowPosition' => 43,],
            [ 'row' => 'D', 'column' => 6, 'rowFlowPosition' => 42, 'columnFlowPosition' => 44,],
            [ 'row' => 'E', 'column' => 6, 'rowFlowPosition' => 54, 'columnFlowPosition' => 45,],
            [ 'row' => 'F', 'column' => 6, 'rowFlowPosition' => 66, 'columnFlowPosition' => 46,],
            [ 'row' => 'G', 'column' => 6, 'rowFlowPosition' => 78, 'columnFlowPosition' => 47,],
            [ 'row' => 'H', 'column' => 6, 'rowFlowPosition' => 90, 'columnFlowPosition' => 48,],
            [ 'row' => 'A', 'column' => 7, 'rowFlowPosition' => 7, 'columnFlowPosition' => 49,],
            [ 'row' => 'B', 'column' => 7, 'rowFlowPosition' => 19, 'columnFlowPosition' => 50,],
            [ 'row' => 'C', 'column' => 7, 'rowFlowPosition' => 31, 'columnFlowPosition' => 51,],
            [ 'row' => 'D', 'column' => 7, 'rowFlowPosition' => 43, 'columnFlowPosition' => 52,],
            [ 'row' => 'E', 'column' => 7, 'rowFlowPosition' => 55, 'columnFlowPosition' => 53,],
            [ 'row' => 'F', 'column' => 7, 'rowFlowPosition' => 67, 'columnFlowPosition' => 54,],
            [ 'row' => 'G', 'column' => 7, 'rowFlowPosition' => 79, 'columnFlowPosition' => 55,],
            [ 'row' => 'H', 'column' => 7, 'rowFlowPosition' => 91, 'columnFlowPosition' => 56,],
            [ 'row' => 'A', 'column' => 8, 'rowFlowPosition' => 8, 'columnFlowPosition' => 57,],
            [ 'row' => 'B', 'column' => 8, 'rowFlowPosition' => 20, 'columnFlowPosition' => 58,],
            [ 'row' => 'C', 'column' => 8, 'rowFlowPosition' => 32, 'columnFlowPosition' => 59,],
            [ 'row' => 'D', 'column' => 8, 'rowFlowPosition' => 44, 'columnFlowPosition' => 60,],
            [ 'row' => 'E', 'column' => 8, 'rowFlowPosition' => 56, 'columnFlowPosition' => 61,],
            [ 'row' => 'F', 'column' => 8, 'rowFlowPosition' => 68, 'columnFlowPosition' => 62,],
            [ 'row' => 'G', 'column' => 8, 'rowFlowPosition' => 80, 'columnFlowPosition' => 63,],
            [ 'row' => 'H', 'column' => 8, 'rowFlowPosition' => 92, 'columnFlowPosition' => 64,],
            [ 'row' => 'A', 'column' => 9, 'rowFlowPosition' => 9, 'columnFlowPosition' => 65,],
            [ 'row' => 'B', 'column' => 9, 'rowFlowPosition' => 21, 'columnFlowPosition' => 66,],
            [ 'row' => 'C', 'column' => 9, 'rowFlowPosition' => 33, 'columnFlowPosition' => 67,],
            [ 'row' => 'D', 'column' => 9, 'rowFlowPosition' => 45, 'columnFlowPosition' => 68,],
            [ 'row' => 'E', 'column' => 9, 'rowFlowPosition' => 57, 'columnFlowPosition' => 69,],
            [ 'row' => 'F', 'column' => 9, 'rowFlowPosition' => 69, 'columnFlowPosition' => 70,],
            [ 'row' => 'G', 'column' => 9, 'rowFlowPosition' => 81, 'columnFlowPosition' => 71,],
            [ 'row' => 'H', 'column' => 9, 'rowFlowPosition' => 93, 'columnFlowPosition' => 72,],
            [ 'row' => 'A', 'column' => 10, 'rowFlowPosition' => 10, 'columnFlowPosition' => 73,],
            [ 'row' => 'B', 'column' => 10, 'rowFlowPosition' => 22, 'columnFlowPosition' => 74,],
            [ 'row' => 'C', 'column' => 10, 'rowFlowPosition' => 34, 'columnFlowPosition' => 75,],
            [ 'row' => 'D', 'column' => 10, 'rowFlowPosition' => 46, 'columnFlowPosition' => 76,],
            [ 'row' => 'E', 'column' => 10, 'rowFlowPosition' => 58, 'columnFlowPosition' => 77,],
            [ 'row' => 'F', 'column' => 10, 'rowFlowPosition' => 70, 'columnFlowPosition' => 78,],
            [ 'row' => 'G', 'column' => 10, 'rowFlowPosition' => 82, 'columnFlowPosition' => 79,],
            [ 'row' => 'H', 'column' => 10, 'rowFlowPosition' => 94, 'columnFlowPosition' => 80,],
            [ 'row' => 'A', 'column' => 11, 'rowFlowPosition' => 11, 'columnFlowPosition' => 81,],
            [ 'row' => 'B', 'column' => 11, 'rowFlowPosition' => 23, 'columnFlowPosition' => 82,],
            [ 'row' => 'C', 'column' => 11, 'rowFlowPosition' => 35, 'columnFlowPosition' => 83,],
            [ 'row' => 'D', 'column' => 11, 'rowFlowPosition' => 47, 'columnFlowPosition' => 84,],
            [ 'row' => 'E', 'column' => 11, 'rowFlowPosition' => 59, 'columnFlowPosition' => 85,],
            [ 'row' => 'F', 'column' => 11, 'rowFlowPosition' => 71, 'columnFlowPosition' => 86,],
            [ 'row' => 'G', 'column' => 11, 'rowFlowPosition' => 83, 'columnFlowPosition' => 87,],
            [ 'row' => 'H', 'column' => 11, 'rowFlowPosition' => 95, 'columnFlowPosition' => 88,],
            [ 'row' => 'A', 'column' => 12, 'rowFlowPosition' => 12, 'columnFlowPosition' => 89,],
            [ 'row' => 'B', 'column' => 12, 'rowFlowPosition' => 24, 'columnFlowPosition' => 90,],
            [ 'row' => 'C', 'column' => 12, 'rowFlowPosition' => 36, 'columnFlowPosition' => 91,],
            [ 'row' => 'D', 'column' => 12, 'rowFlowPosition' => 48, 'columnFlowPosition' => 92,],
            [ 'row' => 'E', 'column' => 12, 'rowFlowPosition' => 60, 'columnFlowPosition' => 93,],
            [ 'row' => 'F', 'column' => 12, 'rowFlowPosition' => 72, 'columnFlowPosition' => 94,],
            [ 'row' => 'G', 'column' => 12, 'rowFlowPosition' => 84, 'columnFlowPosition' => 95,],
            [ 'row' => 'H', 'column' => 12, 'rowFlowPosition' => 96, 'columnFlowPosition' => 96,],
        ];
    }

    /** @dataProvider dataProvider12Well */
    #[DataProvider('dataProvider12Well')]
    public function testPosition12Well(string $row, int $column, int $rowFlowPosition, int $columnFlowPosition): void
    {
        $coordinates = new Coordinates($row, $column, new CoordinateSystem12Well());
        self::assertSame($columnFlowPosition, $coordinates->position(FlowDirection::COLUMN()));
        self::assertSame($rowFlowPosition, $coordinates->position(FlowDirection::ROW()));
    }

    /** @return list<array{row: string, column: int, rowFlowPosition: int, columnFlowPosition: int}> */
    public static function dataProvider12Well(): array
    {
        return [
            [
                'row' => 'A',
                'column' => 1,
                'rowFlowPosition' => 1,
                'columnFlowPosition' => 1,
            ],
            [
                'row' => 'A',
                'column' => 2,
                'rowFlowPosition' => 2,
                'columnFlowPosition' => 4,
            ],
            [
                'row' => 'A',
                'column' => 3,
                'rowFlowPosition' => 3,
                'columnFlowPosition' => 7,
            ],
            [
                'row' => 'A',
                'column' => 4,
                'rowFlowPosition' => 4,
                'columnFlowPosition' => 10,
            ],
            [
                'row' => 'B',
                'column' => 1,
                'rowFlowPosition' => 5,
                'columnFlowPosition' => 2,
            ],
            [
                'row' => 'B',
                'column' => 2,
                'rowFlowPosition' => 6,
                'columnFlowPosition' => 5,
            ],
            [
                'row' => 'B',
                'column' => 3,
                'rowFlowPosition' => 7,
                'columnFlowPosition' => 8,
            ],
            [
                'row' => 'B',
                'column' => 4,
                'rowFlowPosition' => 8,
                'columnFlowPosition' => 11,
            ],
            [
                'row' => 'C',
                'column' => 1,
                'rowFlowPosition' => 9,
                'columnFlowPosition' => 3,
            ],
            [
                'row' => 'C',
                'column' => 2,
                'rowFlowPosition' => 10,
                'columnFlowPosition' => 6,
            ],
            [
                'row' => 'C',
                'column' => 3,
                'rowFlowPosition' => 11,
                'columnFlowPosition' => 9,
            ],
            [
                'row' => 'C',
                'column' => 4,
                'rowFlowPosition' => 12,
                'columnFlowPosition' => 12,
            ],
        ];
    }

    /** @dataProvider invalidRowsOrColumns */
    #[DataProvider('invalidRowsOrColumns')]
    public function testThrowsOnInvalidRowsOrColumns(string $row, int $column): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Coordinates($row, $column, new CoordinateSystem96Well());
    }

    /** @return iterable<array{string, int}> */
    public static function invalidRowsOrColumns(): iterable
    {
        yield ['X', 2];
        yield ['B', 0];
        yield ['B', 13];
        yield ['B', -1];
        yield ['B', 1000];
        yield ['rolf', 2];
    }

    /** @dataProvider invalidPositions */
    #[DataProvider('invalidPositions')]
    public function testThrowsOnInvalidPositions(int $position): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Coordinates::fromPosition($position, FlowDirection::COLUMN(), new CoordinateSystem96Well());
    }

    /** @return iterable<array{int}> */
    public static function invalidPositions(): iterable
    {
        yield [0];
        yield [-1];
        yield [97];
        yield [10000];
    }

    /** @dataProvider invalidCoordinates */
    #[DataProvider('invalidCoordinates')]
    public function testThrowsOnInvalidCoordinates(string $coordinatesString): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Coordinates::fromString($coordinatesString, new CoordinateSystem96Well());
    }

    /** @return iterable<array{string}> */
    public static function invalidCoordinates(): iterable
    {
        yield ['A0'];
        yield ['A001'];
        yield ['X3'];
        yield ['rolf'];
        yield ['a1'];
    }

    /**
     * @return array<array{
     *   row: string,
     *   column: int,
     *   rowFlowPosition: int,
     *   columnFlowPosition: int,
     * }>
     */
    public static function data2x16Wells(): array
    {
        return [
            [ 'row' => 'A', 'column' => 1, 'rowFlowPosition' => 1, 'columnFlowPosition' => 1,],
            [ 'row' => 'B', 'column' => 1, 'rowFlowPosition' => 3, 'columnFlowPosition' => 2,],
            [ 'row' => 'C', 'column' => 1, 'rowFlowPosition' => 5, 'columnFlowPosition' => 3,],
            [ 'row' => 'D', 'column' => 1, 'rowFlowPosition' => 7, 'columnFlowPosition' => 4,],
            [ 'row' => 'E', 'column' => 1, 'rowFlowPosition' => 9, 'columnFlowPosition' => 5,],
            [ 'row' => 'F', 'column' => 1, 'rowFlowPosition' => 11, 'columnFlowPosition' => 6,],
            [ 'row' => 'G', 'column' => 1, 'rowFlowPosition' => 13, 'columnFlowPosition' => 7,],
            [ 'row' => 'H', 'column' => 1, 'rowFlowPosition' => 15, 'columnFlowPosition' => 8,],
            [ 'row' => 'I', 'column' => 1, 'rowFlowPosition' => 17, 'columnFlowPosition' => 9,],
            [ 'row' => 'J', 'column' => 1, 'rowFlowPosition' => 19, 'columnFlowPosition' => 10,],
            [ 'row' => 'K', 'column' => 1, 'rowFlowPosition' => 21, 'columnFlowPosition' => 11,],
            [ 'row' => 'L', 'column' => 1, 'rowFlowPosition' => 23, 'columnFlowPosition' => 12,],
            [ 'row' => 'M', 'column' => 1, 'rowFlowPosition' => 25, 'columnFlowPosition' => 13,],
            [ 'row' => 'N', 'column' => 1, 'rowFlowPosition' => 27, 'columnFlowPosition' => 14,],
            [ 'row' => 'O', 'column' => 1, 'rowFlowPosition' => 29, 'columnFlowPosition' => 15,],
            [ 'row' => 'P', 'column' => 1, 'rowFlowPosition' => 31, 'columnFlowPosition' => 16,],
            [ 'row' => 'A', 'column' => 2, 'rowFlowPosition' => 2, 'columnFlowPosition' => 17,],
            [ 'row' => 'B', 'column' => 2, 'rowFlowPosition' => 4, 'columnFlowPosition' => 18,],
            [ 'row' => 'C', 'column' => 2, 'rowFlowPosition' => 6, 'columnFlowPosition' => 19,],
            [ 'row' => 'D', 'column' => 2, 'rowFlowPosition' => 8, 'columnFlowPosition' => 20,],
            [ 'row' => 'E', 'column' => 2, 'rowFlowPosition' => 10, 'columnFlowPosition' => 21,],
            [ 'row' => 'F', 'column' => 2, 'rowFlowPosition' => 12, 'columnFlowPosition' => 22,],
            [ 'row' => 'G', 'column' => 2, 'rowFlowPosition' => 14, 'columnFlowPosition' => 23,],
            [ 'row' => 'H', 'column' => 2, 'rowFlowPosition' => 16, 'columnFlowPosition' => 24,],
            [ 'row' => 'I', 'column' => 2, 'rowFlowPosition' => 18, 'columnFlowPosition' => 25,],
            [ 'row' => 'J', 'column' => 2, 'rowFlowPosition' => 20, 'columnFlowPosition' => 26,],
            [ 'row' => 'K', 'column' => 2, 'rowFlowPosition' => 22, 'columnFlowPosition' => 27,],
            [ 'row' => 'L', 'column' => 2, 'rowFlowPosition' => 24, 'columnFlowPosition' => 28,],
            [ 'row' => 'M', 'column' => 2, 'rowFlowPosition' => 26, 'columnFlowPosition' => 29,],
            [ 'row' => 'N', 'column' => 2, 'rowFlowPosition' => 28, 'columnFlowPosition' => 30,],
            [ 'row' => 'O', 'column' => 2, 'rowFlowPosition' => 30, 'columnFlowPosition' => 31,],
            [ 'row' => 'P', 'column' => 2, 'rowFlowPosition' => 32, 'columnFlowPosition' => 32,],
        ];
    }
}

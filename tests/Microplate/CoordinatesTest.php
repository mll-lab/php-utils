<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\CoordinateSystem2x16;
use MLL\Utils\Microplate\CoordinateSystem2x16NoJ;
use MLL\Utils\Microplate\CoordinateSystem4x3;
use MLL\Utils\Microplate\CoordinateSystem6x8;
use MLL\Utils\Microplate\CoordinateSystem8x6;
use MLL\Utils\Microplate\Enums\FlowDirection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @phpstan-type WellData array{
 *    row: string,
 *    column: int,
 *    rowFlowPosition: int,
 *    columnFlowPosition: int,
 *  }
 */
final class CoordinatesTest extends TestCase
{
    /**
     * @dataProvider dataProviderWells
     *
     * @param array<WellData> $wells
     */
    #[DataProvider('dataProviderWells')]
    public function testConstruct(CoordinateSystem $coordinateSystem, array $wells): void
    {
        foreach ($wells as $well) {
            $coordinates = new Coordinates($well['row'], $well['column'], $coordinateSystem);
            self::assertSame($well['row'] . $well['column'], $coordinates->toString());
        }
    }

    /**
     * @dataProvider dataProviderWells
     *
     * @param array<WellData> $wells
     */
    #[DataProvider('dataProviderWells')]
    public function testFromArray(CoordinateSystem $coordinateSystem, array $wells): void
    {
        foreach ($wells as $well) {
            $coordinates = Coordinates::fromArray($well, $coordinateSystem);
            self::assertSame($well['row'] . $well['column'], $coordinates->toString());
        }
    }

    /**
     * @dataProvider dataProviderWells
     *
     * @param array<WellData> $wells
     */
    #[DataProvider('dataProviderWells')]
    public function testFromPosition(CoordinateSystem $coordinateSystem, array $wells): void
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

    /**
     * @dataProvider dataProviderWells
     *
     * @param array<WellData> $wells
     */
    #[DataProvider('dataProviderWells')]
    public function testFromString(CoordinateSystem $coordinateSystem, array $wells): void
    {
        foreach ($wells as $well) {
            $coordinates = Coordinates::fromString($well['row'] . $well['column'], $coordinateSystem);
            self::assertSame($well['row'], $coordinates->row);
            self::assertSame($well['column'], $coordinates->column);
        }
    }

    /**
     * @dataProvider dataProviderPaddedWells
     *
     * @param array<array{
     *     paddedCoordinates: string,
     *     row: string,
     *     column: int
     * }> $paddedWells
     */
    #[DataProvider('dataProviderPaddedWells')]
    public function testFromPaddedCoordinatesString(CoordinateSystem $coordinateSystem, array $paddedWells): void
    {
        foreach ($paddedWells as $paddedWell) {
            $coordinatesFromPadded = Coordinates::fromString($paddedWell['paddedCoordinates'], $coordinateSystem);
            self::assertSame($paddedWell['row'], $coordinatesFromPadded->row);
            self::assertSame($paddedWell['column'], $coordinatesFromPadded->column);
            self::assertSame($paddedWell['paddedCoordinates'], $coordinatesFromPadded->toPaddedString());
        }
    }

    /**
     * @dataProvider dataProviderWells
     *
     * @param array<WellData> $wells
     */
    #[DataProvider('dataProviderWells')]
    public function testPosition(CoordinateSystem $coordinateSystem, array $wells): void
    {
        foreach ($wells as $well) {
            $coordinates = Coordinates::fromArray($well, $coordinateSystem);
            self::assertSame($well['columnFlowPosition'], $coordinates->position(FlowDirection::COLUMN()));
            self::assertSame($well['rowFlowPosition'], $coordinates->position(FlowDirection::ROW()));
        }
    }

    public function testEquals(): void
    {
        $a1on6x8 = new Coordinates('A', 1, new CoordinateSystem6x8());
        self::assertTrue($a1on6x8->equals($a1on6x8));

        $a1on6x8AnotherInstance = new Coordinates('A', 1, new CoordinateSystem6x8());
        self::assertTrue($a1on6x8->equals($a1on6x8AnotherInstance));
        self::assertTrue($a1on6x8AnotherInstance->equals($a1on6x8));

        $a1on8x6 = new Coordinates('A', 1, new CoordinateSystem8x6());
        self::assertFalse($a1on6x8->equals($a1on8x6));
        self::assertFalse($a1on8x6->equals($a1on6x8));

        $a2on6x8 = new Coordinates('A', 2, new CoordinateSystem8x6());
        self::assertFalse($a1on6x8->equals($a2on6x8));
        self::assertFalse($a2on6x8->equals($a1on6x8));

        $b1on6x8 = new Coordinates('B', 1, new CoordinateSystem8x6());
        self::assertFalse($a1on6x8->equals($b1on6x8));
        self::assertFalse($b1on6x8->equals($a1on6x8));
    }

    /**
     * @return iterable<
     *   array{
     *     CoordinateSystem,
     *     array<
     *       array{
     *         paddedCoordinates: string,
     *         row: string,
     *         column: int,
     *       }
     *     >
     *   }
     * > $paddedWells
     */
    public static function dataProviderPaddedWells(): iterable
    {
        yield '4x3' => [
            new CoordinateSystem4x3(),
            [
                ['paddedCoordinates' => 'A1', 'row' => 'A', 'column' => 1],
                ['paddedCoordinates' => 'C4', 'row' => 'C', 'column' => 4],
            ],
        ];
        yield '8x6' => [
            new CoordinateSystem8x6(),
            [
                ['paddedCoordinates' => 'A1', 'row' => 'A', 'column' => 1],
                ['paddedCoordinates' => 'F8', 'row' => 'F', 'column' => 8],
            ],
        ];
        yield '6x8' => [
            new CoordinateSystem6x8(),
            [
                ['paddedCoordinates' => 'A1', 'row' => 'A', 'column' => 1],
                ['paddedCoordinates' => 'H6', 'row' => 'H', 'column' => 6],
            ],
        ];
        yield '12x8' => [
            new CoordinateSystem12x8(),
            [
                ['paddedCoordinates' => 'A01', 'row' => 'A', 'column' => 1],
                ['paddedCoordinates' => 'C05', 'row' => 'C', 'column' => 5],
                ['paddedCoordinates' => 'H12', 'row' => 'H', 'column' => 12],
                ['paddedCoordinates' => 'D10', 'row' => 'D', 'column' => 10],
            ],
        ];
        yield '2x16' => [
            new CoordinateSystem2x16(),
            [
                ['paddedCoordinates' => 'A1', 'row' => 'A', 'column' => 1],
                ['paddedCoordinates' => 'B2', 'row' => 'B', 'column' => 2],
                ['paddedCoordinates' => 'M1', 'row' => 'M', 'column' => 1],
                ['paddedCoordinates' => 'K2', 'row' => 'K', 'column' => 2],
            ],
        ];
    }

    /** @return iterable<array{CoordinateSystem, array<WellData>}> */
    public static function dataProviderWells(): iterable
    {
        yield '2x16' => [new CoordinateSystem2x16(), self::data2x16()];
        yield '2x16NoJ' => [new CoordinateSystem2x16NoJ(), self::data2x16NoJ()];
        yield '4x3' => [new CoordinateSystem4x3(), self::data4x3()];
        yield '8x6' => [new CoordinateSystem8x6(), self::data8x6()];
        yield '12x8' => [new CoordinateSystem12x8(), self::data12x8()];
    }

    /**
     * @dataProvider invalidRowsOrColumns
     *
     * @param array<int, array{string, int}> $rowsAndColumns
     */
    #[DataProvider('invalidRowsOrColumns')]
    public function testThrowsOnInvalidRowsOrColumns(CoordinateSystem $coordinateSystem, array $rowsAndColumns): void
    {
        foreach ($rowsAndColumns as [$row, $column]) {
            $this->expectException(\InvalidArgumentException::class);
            new Coordinates($row, $column, $coordinateSystem);
        }
    }

    /** @return iterable<array{CoordinateSystem, array<array{string, int}>}> */
    public static function invalidRowsOrColumns(): iterable
    {
        yield '2x16' => [new CoordinateSystem2x16(), [['X', 2], ['B', 0], ['B', 3], ['B', -1], ['B', 1000], ['rolf', 2]]];
        yield '2x16NoJ' => [new CoordinateSystem2x16NoJ(), [['J', 1], ['J', 2],]];
        yield '4x3' => [new CoordinateSystem4x3(), [['X', 2], ['B', 0], ['B', 4], ['B', -1], ['B', 1000], ['rolf', 2], ['D', 1]]];
        yield '8x6' => [new CoordinateSystem8x6(), [['X', 2], ['B', 0], ['B', 4], ['B', -1], ['B', 1000], ['rolf', 2], ['G', 1]]];
        yield '12x8' => [new CoordinateSystem12x8(), [['X', 2], ['B', 0], ['B', 13], ['B', -1], ['B', 1000], ['rolf', 2]]];
    }

    /**
     * @dataProvider invalidPositions
     *
     * @param array<int> $positions
     */
    #[DataProvider('invalidPositions')]
    public function testThrowsOnInvalidPositions(CoordinateSystem $coordinateSystem, array $positions): void
    {
        foreach ($positions as $position) {
            $this->expectException(\InvalidArgumentException::class);
            Coordinates::fromPosition($position, FlowDirection::COLUMN(), new CoordinateSystem12x8());
        }
    }

    /** @return iterable<array{CoordinateSystem, array<int>}> */
    public static function invalidPositions(): iterable
    {
        yield '2x16' => [new CoordinateSystem2x16(), [0, -1, 33, 10000]];
        yield '2x16NoJ' => [new CoordinateSystem2x16NoJ(), [0, -1, 33, 10000]];
        yield '4x3' => [new CoordinateSystem4x3(), [0, -1, 13, 10000]];
        yield '8x6' => [new CoordinateSystem8x6(), [0, -1, 49, 10000]];
        yield '12x8' => [new CoordinateSystem12x8(), [0, -1, 97, 10000]];
    }

    /**
     * @dataProvider invalidCoordinates
     *
     * @param array<string> $coordinatesAsString
     */
    #[DataProvider('invalidCoordinates')]
    public function testThrowsOnInvalidCoordinates(CoordinateSystem $coordinateSystem, array $coordinatesAsString): void
    {
        foreach ($coordinatesAsString as $coordinates) {
            $this->expectException(\InvalidArgumentException::class);
            Coordinates::fromString($coordinates, $coordinateSystem);
        }
    }

    /** @return iterable<array{CoordinateSystem, array<string>}> */
    public static function invalidCoordinates(): iterable
    {
        yield '2x16' => [new CoordinateSystem2x16(), ['A0', 'A01', 'D3', 'C5', 'X3', 'rolf', 'a1']];
        yield '2x16NoJ' => [new CoordinateSystem2x16NoJ(), ['J1', 'J2']];
        yield '8x6' => [new CoordinateSystem8x6(), ['A0', 'A01', 'G3', 'C9', 'rolf', 'a1']];
        yield '12x8' => [new CoordinateSystem12x8(), ['A0', 'A001', 'X3', 'rolf', 'a1']];
    }

    /** @return array<WellData> */
    public static function data2x16(): array
    {
        return [
            ['row' => 'A', 'column' => 1, 'rowFlowPosition' => 1, 'columnFlowPosition' => 1],
            ['row' => 'B', 'column' => 1, 'rowFlowPosition' => 3, 'columnFlowPosition' => 2],
            ['row' => 'C', 'column' => 1, 'rowFlowPosition' => 5, 'columnFlowPosition' => 3],
            ['row' => 'D', 'column' => 1, 'rowFlowPosition' => 7, 'columnFlowPosition' => 4],
            ['row' => 'E', 'column' => 1, 'rowFlowPosition' => 9, 'columnFlowPosition' => 5],
            ['row' => 'F', 'column' => 1, 'rowFlowPosition' => 11, 'columnFlowPosition' => 6],
            ['row' => 'G', 'column' => 1, 'rowFlowPosition' => 13, 'columnFlowPosition' => 7],
            ['row' => 'H', 'column' => 1, 'rowFlowPosition' => 15, 'columnFlowPosition' => 8],
            ['row' => 'I', 'column' => 1, 'rowFlowPosition' => 17, 'columnFlowPosition' => 9],
            ['row' => 'J', 'column' => 1, 'rowFlowPosition' => 19, 'columnFlowPosition' => 10],
            ['row' => 'K', 'column' => 1, 'rowFlowPosition' => 21, 'columnFlowPosition' => 11],
            ['row' => 'L', 'column' => 1, 'rowFlowPosition' => 23, 'columnFlowPosition' => 12],
            ['row' => 'M', 'column' => 1, 'rowFlowPosition' => 25, 'columnFlowPosition' => 13],
            ['row' => 'N', 'column' => 1, 'rowFlowPosition' => 27, 'columnFlowPosition' => 14],
            ['row' => 'O', 'column' => 1, 'rowFlowPosition' => 29, 'columnFlowPosition' => 15],
            ['row' => 'P', 'column' => 1, 'rowFlowPosition' => 31, 'columnFlowPosition' => 16],
            ['row' => 'A', 'column' => 2, 'rowFlowPosition' => 2, 'columnFlowPosition' => 17],
            ['row' => 'B', 'column' => 2, 'rowFlowPosition' => 4, 'columnFlowPosition' => 18],
            ['row' => 'C', 'column' => 2, 'rowFlowPosition' => 6, 'columnFlowPosition' => 19],
            ['row' => 'D', 'column' => 2, 'rowFlowPosition' => 8, 'columnFlowPosition' => 20],
            ['row' => 'E', 'column' => 2, 'rowFlowPosition' => 10, 'columnFlowPosition' => 21],
            ['row' => 'F', 'column' => 2, 'rowFlowPosition' => 12, 'columnFlowPosition' => 22],
            ['row' => 'G', 'column' => 2, 'rowFlowPosition' => 14, 'columnFlowPosition' => 23],
            ['row' => 'H', 'column' => 2, 'rowFlowPosition' => 16, 'columnFlowPosition' => 24],
            ['row' => 'I', 'column' => 2, 'rowFlowPosition' => 18, 'columnFlowPosition' => 25],
            ['row' => 'J', 'column' => 2, 'rowFlowPosition' => 20, 'columnFlowPosition' => 26],
            ['row' => 'K', 'column' => 2, 'rowFlowPosition' => 22, 'columnFlowPosition' => 27],
            ['row' => 'L', 'column' => 2, 'rowFlowPosition' => 24, 'columnFlowPosition' => 28],
            ['row' => 'M', 'column' => 2, 'rowFlowPosition' => 26, 'columnFlowPosition' => 29],
            ['row' => 'N', 'column' => 2, 'rowFlowPosition' => 28, 'columnFlowPosition' => 30],
            ['row' => 'O', 'column' => 2, 'rowFlowPosition' => 30, 'columnFlowPosition' => 31],
            ['row' => 'P', 'column' => 2, 'rowFlowPosition' => 32, 'columnFlowPosition' => 32],
        ];
    }

    public static function data2x16NoJ(): array
    {
        return [
            ['row' => 'A', 'column' => 1, 'rowFlowPosition' => 1, 'columnFlowPosition' => 1],
            ['row' => 'B', 'column' => 1, 'rowFlowPosition' => 3, 'columnFlowPosition' => 2],
            ['row' => 'C', 'column' => 1, 'rowFlowPosition' => 5, 'columnFlowPosition' => 3],
            ['row' => 'D', 'column' => 1, 'rowFlowPosition' => 7, 'columnFlowPosition' => 4],
            ['row' => 'E', 'column' => 1, 'rowFlowPosition' => 9, 'columnFlowPosition' => 5],
            ['row' => 'F', 'column' => 1, 'rowFlowPosition' => 11, 'columnFlowPosition' => 6],
            ['row' => 'G', 'column' => 1, 'rowFlowPosition' => 13, 'columnFlowPosition' => 7],
            ['row' => 'H', 'column' => 1, 'rowFlowPosition' => 15, 'columnFlowPosition' => 8],
            ['row' => 'I', 'column' => 1, 'rowFlowPosition' => 17, 'columnFlowPosition' => 9],
            ['row' => 'K', 'column' => 1, 'rowFlowPosition' => 19, 'columnFlowPosition' => 10],
            ['row' => 'L', 'column' => 1, 'rowFlowPosition' => 21, 'columnFlowPosition' => 11],
            ['row' => 'M', 'column' => 1, 'rowFlowPosition' => 23, 'columnFlowPosition' => 12],
            ['row' => 'N', 'column' => 1, 'rowFlowPosition' => 25, 'columnFlowPosition' => 13],
            ['row' => 'O', 'column' => 1, 'rowFlowPosition' => 27, 'columnFlowPosition' => 14],
            ['row' => 'P', 'column' => 1, 'rowFlowPosition' => 29, 'columnFlowPosition' => 15],
            ['row' => 'Q', 'column' => 1, 'rowFlowPosition' => 31, 'columnFlowPosition' => 16],
            ['row' => 'A', 'column' => 2, 'rowFlowPosition' => 2, 'columnFlowPosition' => 17],
            ['row' => 'B', 'column' => 2, 'rowFlowPosition' => 4, 'columnFlowPosition' => 18],
            ['row' => 'C', 'column' => 2, 'rowFlowPosition' => 6, 'columnFlowPosition' => 19],
            ['row' => 'D', 'column' => 2, 'rowFlowPosition' => 8, 'columnFlowPosition' => 20],
            ['row' => 'E', 'column' => 2, 'rowFlowPosition' => 10, 'columnFlowPosition' => 21],
            ['row' => 'F', 'column' => 2, 'rowFlowPosition' => 12, 'columnFlowPosition' => 22],
            ['row' => 'G', 'column' => 2, 'rowFlowPosition' => 14, 'columnFlowPosition' => 23],
            ['row' => 'H', 'column' => 2, 'rowFlowPosition' => 16, 'columnFlowPosition' => 24],
            ['row' => 'I', 'column' => 2, 'rowFlowPosition' => 18, 'columnFlowPosition' => 25],
            ['row' => 'K', 'column' => 2, 'rowFlowPosition' => 20, 'columnFlowPosition' => 26],
            ['row' => 'L', 'column' => 2, 'rowFlowPosition' => 22, 'columnFlowPosition' => 27],
            ['row' => 'M', 'column' => 2, 'rowFlowPosition' => 24, 'columnFlowPosition' => 28],
            ['row' => 'N', 'column' => 2, 'rowFlowPosition' => 26, 'columnFlowPosition' => 29],
            ['row' => 'O', 'column' => 2, 'rowFlowPosition' => 28, 'columnFlowPosition' => 30],
            ['row' => 'P', 'column' => 2, 'rowFlowPosition' => 30, 'columnFlowPosition' => 31],
            ['row' => 'Q', 'column' => 2, 'rowFlowPosition' => 32, 'columnFlowPosition' => 32],
        ];
    }

    /** @return array<WellData> */
    public static function data4x3(): array
    {
        return [
            ['row' => 'A', 'column' => 1, 'rowFlowPosition' => 1, 'columnFlowPosition' => 1],
            ['row' => 'A', 'column' => 2, 'rowFlowPosition' => 2, 'columnFlowPosition' => 4],
            ['row' => 'A', 'column' => 3, 'rowFlowPosition' => 3, 'columnFlowPosition' => 7],
            ['row' => 'A', 'column' => 4, 'rowFlowPosition' => 4, 'columnFlowPosition' => 10],
            ['row' => 'B', 'column' => 1, 'rowFlowPosition' => 5, 'columnFlowPosition' => 2],
            ['row' => 'B', 'column' => 2, 'rowFlowPosition' => 6, 'columnFlowPosition' => 5],
            ['row' => 'B', 'column' => 3, 'rowFlowPosition' => 7, 'columnFlowPosition' => 8],
            ['row' => 'B', 'column' => 4, 'rowFlowPosition' => 8, 'columnFlowPosition' => 11],
            ['row' => 'C', 'column' => 1, 'rowFlowPosition' => 9, 'columnFlowPosition' => 3],
            ['row' => 'C', 'column' => 2, 'rowFlowPosition' => 10, 'columnFlowPosition' => 6],
            ['row' => 'C', 'column' => 3, 'rowFlowPosition' => 11, 'columnFlowPosition' => 9],
            ['row' => 'C', 'column' => 4, 'rowFlowPosition' => 12, 'columnFlowPosition' => 12],
        ];
    }

    /** @return array<WellData> */
    public static function data8x6(): array
    {
        return [
            ['row' => 'A', 'column' => 1, 'rowFlowPosition' => 1, 'columnFlowPosition' => 1],
            ['row' => 'A', 'column' => 2, 'rowFlowPosition' => 2, 'columnFlowPosition' => 7],
            ['row' => 'A', 'column' => 3, 'rowFlowPosition' => 3, 'columnFlowPosition' => 13],
            ['row' => 'A', 'column' => 4, 'rowFlowPosition' => 4, 'columnFlowPosition' => 19],
            ['row' => 'A', 'column' => 5, 'rowFlowPosition' => 5, 'columnFlowPosition' => 25],
            ['row' => 'A', 'column' => 6, 'rowFlowPosition' => 6, 'columnFlowPosition' => 31],
            ['row' => 'A', 'column' => 7, 'rowFlowPosition' => 7, 'columnFlowPosition' => 37],
            ['row' => 'A', 'column' => 8, 'rowFlowPosition' => 8, 'columnFlowPosition' => 43],
            ['row' => 'B', 'column' => 1, 'rowFlowPosition' => 9, 'columnFlowPosition' => 2],
            ['row' => 'B', 'column' => 2, 'rowFlowPosition' => 10, 'columnFlowPosition' => 8],
            ['row' => 'B', 'column' => 3, 'rowFlowPosition' => 11, 'columnFlowPosition' => 14],
            ['row' => 'B', 'column' => 4, 'rowFlowPosition' => 12, 'columnFlowPosition' => 20],
            ['row' => 'B', 'column' => 5, 'rowFlowPosition' => 13, 'columnFlowPosition' => 26],
            ['row' => 'B', 'column' => 6, 'rowFlowPosition' => 14, 'columnFlowPosition' => 32],
            ['row' => 'B', 'column' => 7, 'rowFlowPosition' => 15, 'columnFlowPosition' => 38],
            ['row' => 'B', 'column' => 8, 'rowFlowPosition' => 16, 'columnFlowPosition' => 44],
            ['row' => 'C', 'column' => 1, 'rowFlowPosition' => 17, 'columnFlowPosition' => 3],
            ['row' => 'C', 'column' => 2, 'rowFlowPosition' => 18, 'columnFlowPosition' => 9],
            ['row' => 'C', 'column' => 3, 'rowFlowPosition' => 19, 'columnFlowPosition' => 15],
            ['row' => 'C', 'column' => 4, 'rowFlowPosition' => 20, 'columnFlowPosition' => 21],
            ['row' => 'C', 'column' => 5, 'rowFlowPosition' => 21, 'columnFlowPosition' => 27],
            ['row' => 'C', 'column' => 6, 'rowFlowPosition' => 22, 'columnFlowPosition' => 33],
            ['row' => 'C', 'column' => 7, 'rowFlowPosition' => 23, 'columnFlowPosition' => 39],
            ['row' => 'C', 'column' => 8, 'rowFlowPosition' => 24, 'columnFlowPosition' => 45],
            ['row' => 'D', 'column' => 1, 'rowFlowPosition' => 25, 'columnFlowPosition' => 4],
            ['row' => 'D', 'column' => 2, 'rowFlowPosition' => 26, 'columnFlowPosition' => 10],
            ['row' => 'D', 'column' => 3, 'rowFlowPosition' => 27, 'columnFlowPosition' => 16],
            ['row' => 'D', 'column' => 4, 'rowFlowPosition' => 28, 'columnFlowPosition' => 22],
            ['row' => 'D', 'column' => 5, 'rowFlowPosition' => 29, 'columnFlowPosition' => 28],
            ['row' => 'D', 'column' => 6, 'rowFlowPosition' => 30, 'columnFlowPosition' => 34],
            ['row' => 'D', 'column' => 7, 'rowFlowPosition' => 31, 'columnFlowPosition' => 40],
            ['row' => 'D', 'column' => 8, 'rowFlowPosition' => 32, 'columnFlowPosition' => 46],
            ['row' => 'E', 'column' => 1, 'rowFlowPosition' => 33, 'columnFlowPosition' => 5],
            ['row' => 'E', 'column' => 2, 'rowFlowPosition' => 34, 'columnFlowPosition' => 11],
            ['row' => 'E', 'column' => 3, 'rowFlowPosition' => 35, 'columnFlowPosition' => 17],
            ['row' => 'E', 'column' => 4, 'rowFlowPosition' => 36, 'columnFlowPosition' => 23],
            ['row' => 'E', 'column' => 5, 'rowFlowPosition' => 37, 'columnFlowPosition' => 29],
            ['row' => 'E', 'column' => 6, 'rowFlowPosition' => 38, 'columnFlowPosition' => 35],
            ['row' => 'E', 'column' => 7, 'rowFlowPosition' => 39, 'columnFlowPosition' => 41],
            ['row' => 'E', 'column' => 8, 'rowFlowPosition' => 40, 'columnFlowPosition' => 47],
            ['row' => 'F', 'column' => 1, 'rowFlowPosition' => 41, 'columnFlowPosition' => 6],
            ['row' => 'F', 'column' => 2, 'rowFlowPosition' => 42, 'columnFlowPosition' => 12],
            ['row' => 'F', 'column' => 3, 'rowFlowPosition' => 43, 'columnFlowPosition' => 18],
            ['row' => 'F', 'column' => 4, 'rowFlowPosition' => 44, 'columnFlowPosition' => 24],
            ['row' => 'F', 'column' => 5, 'rowFlowPosition' => 45, 'columnFlowPosition' => 30],
            ['row' => 'F', 'column' => 6, 'rowFlowPosition' => 46, 'columnFlowPosition' => 36],
            ['row' => 'F', 'column' => 7, 'rowFlowPosition' => 47, 'columnFlowPosition' => 42],
            ['row' => 'F', 'column' => 8, 'rowFlowPosition' => 48, 'columnFlowPosition' => 48],
        ];
    }

    /** @return array<WellData> */
    public static function data12x8(): array
    {
        return [
            ['row' => 'A', 'column' => 1, 'rowFlowPosition' => 1, 'columnFlowPosition' => 1],
            ['row' => 'B', 'column' => 1, 'rowFlowPosition' => 13, 'columnFlowPosition' => 2],
            ['row' => 'C', 'column' => 1, 'rowFlowPosition' => 25, 'columnFlowPosition' => 3],
            ['row' => 'D', 'column' => 1, 'rowFlowPosition' => 37, 'columnFlowPosition' => 4],
            ['row' => 'E', 'column' => 1, 'rowFlowPosition' => 49, 'columnFlowPosition' => 5],
            ['row' => 'F', 'column' => 1, 'rowFlowPosition' => 61, 'columnFlowPosition' => 6],
            ['row' => 'G', 'column' => 1, 'rowFlowPosition' => 73, 'columnFlowPosition' => 7],
            ['row' => 'H', 'column' => 1, 'rowFlowPosition' => 85, 'columnFlowPosition' => 8],
            ['row' => 'A', 'column' => 2, 'rowFlowPosition' => 2, 'columnFlowPosition' => 9],
            ['row' => 'B', 'column' => 2, 'rowFlowPosition' => 14, 'columnFlowPosition' => 10],
            ['row' => 'C', 'column' => 2, 'rowFlowPosition' => 26, 'columnFlowPosition' => 11],
            ['row' => 'D', 'column' => 2, 'rowFlowPosition' => 38, 'columnFlowPosition' => 12],
            ['row' => 'E', 'column' => 2, 'rowFlowPosition' => 50, 'columnFlowPosition' => 13],
            ['row' => 'F', 'column' => 2, 'rowFlowPosition' => 62, 'columnFlowPosition' => 14],
            ['row' => 'G', 'column' => 2, 'rowFlowPosition' => 74, 'columnFlowPosition' => 15],
            ['row' => 'H', 'column' => 2, 'rowFlowPosition' => 86, 'columnFlowPosition' => 16],
            ['row' => 'A', 'column' => 3, 'rowFlowPosition' => 3, 'columnFlowPosition' => 17],
            ['row' => 'B', 'column' => 3, 'rowFlowPosition' => 15, 'columnFlowPosition' => 18],
            ['row' => 'C', 'column' => 3, 'rowFlowPosition' => 27, 'columnFlowPosition' => 19],
            ['row' => 'D', 'column' => 3, 'rowFlowPosition' => 39, 'columnFlowPosition' => 20],
            ['row' => 'E', 'column' => 3, 'rowFlowPosition' => 51, 'columnFlowPosition' => 21],
            ['row' => 'F', 'column' => 3, 'rowFlowPosition' => 63, 'columnFlowPosition' => 22],
            ['row' => 'G', 'column' => 3, 'rowFlowPosition' => 75, 'columnFlowPosition' => 23],
            ['row' => 'H', 'column' => 3, 'rowFlowPosition' => 87, 'columnFlowPosition' => 24],
            ['row' => 'A', 'column' => 4, 'rowFlowPosition' => 4, 'columnFlowPosition' => 25],
            ['row' => 'B', 'column' => 4, 'rowFlowPosition' => 16, 'columnFlowPosition' => 26],
            ['row' => 'C', 'column' => 4, 'rowFlowPosition' => 28, 'columnFlowPosition' => 27],
            ['row' => 'D', 'column' => 4, 'rowFlowPosition' => 40, 'columnFlowPosition' => 28],
            ['row' => 'E', 'column' => 4, 'rowFlowPosition' => 52, 'columnFlowPosition' => 29],
            ['row' => 'F', 'column' => 4, 'rowFlowPosition' => 64, 'columnFlowPosition' => 30],
            ['row' => 'G', 'column' => 4, 'rowFlowPosition' => 76, 'columnFlowPosition' => 31],
            ['row' => 'H', 'column' => 4, 'rowFlowPosition' => 88, 'columnFlowPosition' => 32],
            ['row' => 'A', 'column' => 5, 'rowFlowPosition' => 5, 'columnFlowPosition' => 33],
            ['row' => 'B', 'column' => 5, 'rowFlowPosition' => 17, 'columnFlowPosition' => 34],
            ['row' => 'C', 'column' => 5, 'rowFlowPosition' => 29, 'columnFlowPosition' => 35],
            ['row' => 'D', 'column' => 5, 'rowFlowPosition' => 41, 'columnFlowPosition' => 36],
            ['row' => 'E', 'column' => 5, 'rowFlowPosition' => 53, 'columnFlowPosition' => 37],
            ['row' => 'F', 'column' => 5, 'rowFlowPosition' => 65, 'columnFlowPosition' => 38],
            ['row' => 'G', 'column' => 5, 'rowFlowPosition' => 77, 'columnFlowPosition' => 39],
            ['row' => 'H', 'column' => 5, 'rowFlowPosition' => 89, 'columnFlowPosition' => 40],
            ['row' => 'A', 'column' => 6, 'rowFlowPosition' => 6, 'columnFlowPosition' => 41],
            ['row' => 'B', 'column' => 6, 'rowFlowPosition' => 18, 'columnFlowPosition' => 42],
            ['row' => 'C', 'column' => 6, 'rowFlowPosition' => 30, 'columnFlowPosition' => 43],
            ['row' => 'D', 'column' => 6, 'rowFlowPosition' => 42, 'columnFlowPosition' => 44],
            ['row' => 'E', 'column' => 6, 'rowFlowPosition' => 54, 'columnFlowPosition' => 45],
            ['row' => 'F', 'column' => 6, 'rowFlowPosition' => 66, 'columnFlowPosition' => 46],
            ['row' => 'G', 'column' => 6, 'rowFlowPosition' => 78, 'columnFlowPosition' => 47],
            ['row' => 'H', 'column' => 6, 'rowFlowPosition' => 90, 'columnFlowPosition' => 48],
            ['row' => 'A', 'column' => 7, 'rowFlowPosition' => 7, 'columnFlowPosition' => 49],
            ['row' => 'B', 'column' => 7, 'rowFlowPosition' => 19, 'columnFlowPosition' => 50],
            ['row' => 'C', 'column' => 7, 'rowFlowPosition' => 31, 'columnFlowPosition' => 51],
            ['row' => 'D', 'column' => 7, 'rowFlowPosition' => 43, 'columnFlowPosition' => 52],
            ['row' => 'E', 'column' => 7, 'rowFlowPosition' => 55, 'columnFlowPosition' => 53],
            ['row' => 'F', 'column' => 7, 'rowFlowPosition' => 67, 'columnFlowPosition' => 54],
            ['row' => 'G', 'column' => 7, 'rowFlowPosition' => 79, 'columnFlowPosition' => 55],
            ['row' => 'H', 'column' => 7, 'rowFlowPosition' => 91, 'columnFlowPosition' => 56],
            ['row' => 'A', 'column' => 8, 'rowFlowPosition' => 8, 'columnFlowPosition' => 57],
            ['row' => 'B', 'column' => 8, 'rowFlowPosition' => 20, 'columnFlowPosition' => 58],
            ['row' => 'C', 'column' => 8, 'rowFlowPosition' => 32, 'columnFlowPosition' => 59],
            ['row' => 'D', 'column' => 8, 'rowFlowPosition' => 44, 'columnFlowPosition' => 60],
            ['row' => 'E', 'column' => 8, 'rowFlowPosition' => 56, 'columnFlowPosition' => 61],
            ['row' => 'F', 'column' => 8, 'rowFlowPosition' => 68, 'columnFlowPosition' => 62],
            ['row' => 'G', 'column' => 8, 'rowFlowPosition' => 80, 'columnFlowPosition' => 63],
            ['row' => 'H', 'column' => 8, 'rowFlowPosition' => 92, 'columnFlowPosition' => 64],
            ['row' => 'A', 'column' => 9, 'rowFlowPosition' => 9, 'columnFlowPosition' => 65],
            ['row' => 'B', 'column' => 9, 'rowFlowPosition' => 21, 'columnFlowPosition' => 66],
            ['row' => 'C', 'column' => 9, 'rowFlowPosition' => 33, 'columnFlowPosition' => 67],
            ['row' => 'D', 'column' => 9, 'rowFlowPosition' => 45, 'columnFlowPosition' => 68],
            ['row' => 'E', 'column' => 9, 'rowFlowPosition' => 57, 'columnFlowPosition' => 69],
            ['row' => 'F', 'column' => 9, 'rowFlowPosition' => 69, 'columnFlowPosition' => 70],
            ['row' => 'G', 'column' => 9, 'rowFlowPosition' => 81, 'columnFlowPosition' => 71],
            ['row' => 'H', 'column' => 9, 'rowFlowPosition' => 93, 'columnFlowPosition' => 72],
            ['row' => 'A', 'column' => 10, 'rowFlowPosition' => 10, 'columnFlowPosition' => 73],
            ['row' => 'B', 'column' => 10, 'rowFlowPosition' => 22, 'columnFlowPosition' => 74],
            ['row' => 'C', 'column' => 10, 'rowFlowPosition' => 34, 'columnFlowPosition' => 75],
            ['row' => 'D', 'column' => 10, 'rowFlowPosition' => 46, 'columnFlowPosition' => 76],
            ['row' => 'E', 'column' => 10, 'rowFlowPosition' => 58, 'columnFlowPosition' => 77],
            ['row' => 'F', 'column' => 10, 'rowFlowPosition' => 70, 'columnFlowPosition' => 78],
            ['row' => 'G', 'column' => 10, 'rowFlowPosition' => 82, 'columnFlowPosition' => 79],
            ['row' => 'H', 'column' => 10, 'rowFlowPosition' => 94, 'columnFlowPosition' => 80],
            ['row' => 'A', 'column' => 11, 'rowFlowPosition' => 11, 'columnFlowPosition' => 81],
            ['row' => 'B', 'column' => 11, 'rowFlowPosition' => 23, 'columnFlowPosition' => 82],
            ['row' => 'C', 'column' => 11, 'rowFlowPosition' => 35, 'columnFlowPosition' => 83],
            ['row' => 'D', 'column' => 11, 'rowFlowPosition' => 47, 'columnFlowPosition' => 84],
            ['row' => 'E', 'column' => 11, 'rowFlowPosition' => 59, 'columnFlowPosition' => 85],
            ['row' => 'F', 'column' => 11, 'rowFlowPosition' => 71, 'columnFlowPosition' => 86],
            ['row' => 'G', 'column' => 11, 'rowFlowPosition' => 83, 'columnFlowPosition' => 87],
            ['row' => 'H', 'column' => 11, 'rowFlowPosition' => 95, 'columnFlowPosition' => 88],
            ['row' => 'A', 'column' => 12, 'rowFlowPosition' => 12, 'columnFlowPosition' => 89],
            ['row' => 'B', 'column' => 12, 'rowFlowPosition' => 24, 'columnFlowPosition' => 90],
            ['row' => 'C', 'column' => 12, 'rowFlowPosition' => 36, 'columnFlowPosition' => 91],
            ['row' => 'D', 'column' => 12, 'rowFlowPosition' => 48, 'columnFlowPosition' => 92],
            ['row' => 'E', 'column' => 12, 'rowFlowPosition' => 60, 'columnFlowPosition' => 93],
            ['row' => 'F', 'column' => 12, 'rowFlowPosition' => 72, 'columnFlowPosition' => 94],
            ['row' => 'G', 'column' => 12, 'rowFlowPosition' => 84, 'columnFlowPosition' => 95],
            ['row' => 'H', 'column' => 12, 'rowFlowPosition' => 96, 'columnFlowPosition' => 96],
        ];
    }
}

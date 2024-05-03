<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12Well;
use MLL\Utils\Microplate\CoordinateSystem96Well;
use MLL\Utils\Microplate\Enums\FlowDirection;
use PHPUnit\Framework\TestCase;

final class CoordinatesTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider96Well')]
    /** @dataProvider dataProvider96Well */
    public function testCanConstructFromRowAndColumn(string $row, int $column, int $rowFlowPosition, int $columnFlowPosition): void
    {
        $coordinates96Well = new Coordinates($row, $column, new CoordinateSystem96Well());

        self::assertSame($row . $column, $coordinates96Well->toString());
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider96Well')]
    /** @dataProvider dataProvider96Well */
    public function testCanConstructFromPosition(string $row, int $column, int $rowFlowPosition, int $columnFlowPosition): void
    {
        // test for Column-FlowDirection
        $coordinates = Coordinates::fromPosition(
            $columnFlowPosition,
            FlowDirection::COLUMN(),
            new CoordinateSystem96Well()
        );
        self::assertSame($row, $coordinates->row);
        self::assertSame($column, $coordinates->column);

        // test for Row-FlowDirection
        $coordinates = Coordinates::fromPosition(
            $rowFlowPosition,
            FlowDirection::ROW(),
            new CoordinateSystem96Well()
        );
        self::assertSame($row, $coordinates->row);
        self::assertSame($column, $coordinates->column);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider96Well')]
    /** @dataProvider dataProvider96Well */
    public function testFromCoordinatesString(string $row, int $column, int $rowFlowPosition, int $columnFlowPosition): void
    {
        $coordinates = Coordinates::fromString($row . $column, new CoordinateSystem96Well());
        self::assertSame($row, $coordinates->row);
        self::assertSame($column, $coordinates->column);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProviderPadded96Well')]
    /** @dataProvider dataProviderPadded96Well */
    public function testFromPaddedCoordinatesString(string $paddedCoordinates, string $row, int $column): void
    {
        $coordinatesFromPadded = Coordinates::fromString($paddedCoordinates, new CoordinateSystem96Well());
        self::assertSame($row, $coordinatesFromPadded->row);
        self::assertSame($column, $coordinatesFromPadded->column);
        self::assertSame($paddedCoordinates, $coordinatesFromPadded->toPaddedString());
    }

    /**
     * @return iterable<array{
     *   paddedCoordinates: string,
     *   row: string,
     *   column: int,
     * }>
     */
    public static function dataProviderPadded96Well(): iterable
    {
        yield [
            'paddedCoordinates' => 'A01',
            'row' => 'A',
            'column' => 1,
        ];
        yield [
            'paddedCoordinates' => 'C05',
            'row' => 'C',
            'column' => 5,
        ];
        yield [
            'paddedCoordinates' => 'H12',
            'row' => 'H',
            'column' => 12,
        ];
        yield [
            'paddedCoordinates' => 'D10',
            'row' => 'D',
            'column' => 10,
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider96Well')]
    public function testPosition96Well(string $row, int $column, int $rowFlowPosition, int $columnFlowPosition): void
    {
        $coordinates = new Coordinates($row, $column, new CoordinateSystem96Well());
        self::assertSame($columnFlowPosition, $coordinates->position(FlowDirection::COLUMN()));
        self::assertSame($rowFlowPosition, $coordinates->position(FlowDirection::ROW()));
    }

    /**
     * @return iterable<array{
     *   row: string,
     *   column: int,
     *   rowFlowPosition: int,
     *   columnFlowPosition: int,
     * }>
     */
    public static function dataProvider96Well(): iterable
    {
        yield [
            'row' => 'A',
            'column' => 1,
            'rowFlowPosition' => 1,
            'columnFlowPosition' => 1,
        ];
        yield [
            'row' => 'B',
            'column' => 1,
            'rowFlowPosition' => 13,
            'columnFlowPosition' => 2,
        ];
        yield [
            'row' => 'C',
            'column' => 1,
            'rowFlowPosition' => 25,
            'columnFlowPosition' => 3,
        ];
        yield [
            'row' => 'D',
            'column' => 1,
            'rowFlowPosition' => 37,
            'columnFlowPosition' => 4,
        ];
        yield [
            'row' => 'E',
            'column' => 1,
            'rowFlowPosition' => 49,
            'columnFlowPosition' => 5,
        ];
        yield [
            'row' => 'F',
            'column' => 1,
            'rowFlowPosition' => 61,
            'columnFlowPosition' => 6,
        ];
        yield [
            'row' => 'G',
            'column' => 1,
            'rowFlowPosition' => 73,
            'columnFlowPosition' => 7,
        ];
        yield [
            'row' => 'H',
            'column' => 1,
            'rowFlowPosition' => 85,
            'columnFlowPosition' => 8,
        ];
        yield [
            'row' => 'A',
            'column' => 2,
            'rowFlowPosition' => 2,
            'columnFlowPosition' => 9,
        ];
        yield [
            'row' => 'B',
            'column' => 2,
            'rowFlowPosition' => 14,
            'columnFlowPosition' => 10,
        ];
        yield [
            'row' => 'C',
            'column' => 2,
            'rowFlowPosition' => 26,
            'columnFlowPosition' => 11,
        ];
        yield [
            'row' => 'D',
            'column' => 2,
            'rowFlowPosition' => 38,
            'columnFlowPosition' => 12,
        ];
        yield [
            'row' => 'E',
            'column' => 2,
            'rowFlowPosition' => 50,
            'columnFlowPosition' => 13,
        ];
        yield [
            'row' => 'F',
            'column' => 2,
            'rowFlowPosition' => 62,
            'columnFlowPosition' => 14,
        ];
        yield [
            'row' => 'G',
            'column' => 2,
            'rowFlowPosition' => 74,
            'columnFlowPosition' => 15,
        ];
        yield [
            'row' => 'H',
            'column' => 2,
            'rowFlowPosition' => 86,
            'columnFlowPosition' => 16,
        ];
        yield [
            'row' => 'A',
            'column' => 3,
            'rowFlowPosition' => 3,
            'columnFlowPosition' => 17,
        ];
        yield [
            'row' => 'B',
            'column' => 3,
            'rowFlowPosition' => 15,
            'columnFlowPosition' => 18,
        ];
        yield [
            'row' => 'C',
            'column' => 3,
            'rowFlowPosition' => 27,
            'columnFlowPosition' => 19,
        ];
        yield [
            'row' => 'D',
            'column' => 3,
            'rowFlowPosition' => 39,
            'columnFlowPosition' => 20,
        ];
        yield [
            'row' => 'E',
            'column' => 3,
            'rowFlowPosition' => 51,
            'columnFlowPosition' => 21,
        ];
        yield [
            'row' => 'F',
            'column' => 3,
            'rowFlowPosition' => 63,
            'columnFlowPosition' => 22,
        ];
        yield [
            'row' => 'G',
            'column' => 3,
            'rowFlowPosition' => 75,
            'columnFlowPosition' => 23,
        ];
        yield [
            'row' => 'H',
            'column' => 3,
            'rowFlowPosition' => 87,
            'columnFlowPosition' => 24,
        ];
        yield [
            'row' => 'A',
            'column' => 4,
            'rowFlowPosition' => 4,
            'columnFlowPosition' => 25,
        ];
        yield [
            'row' => 'B',
            'column' => 4,
            'rowFlowPosition' => 16,
            'columnFlowPosition' => 26,
        ];
        yield [
            'row' => 'C',
            'column' => 4,
            'rowFlowPosition' => 28,
            'columnFlowPosition' => 27,
        ];
        yield [
            'row' => 'D',
            'column' => 4,
            'rowFlowPosition' => 40,
            'columnFlowPosition' => 28,
        ];
        yield [
            'row' => 'E',
            'column' => 4,
            'rowFlowPosition' => 52,
            'columnFlowPosition' => 29,
        ];
        yield [
            'row' => 'F',
            'column' => 4,
            'rowFlowPosition' => 64,
            'columnFlowPosition' => 30,
        ];
        yield [
            'row' => 'G',
            'column' => 4,
            'rowFlowPosition' => 76,
            'columnFlowPosition' => 31,
        ];
        yield [
            'row' => 'H',
            'column' => 4,
            'rowFlowPosition' => 88,
            'columnFlowPosition' => 32,
        ];
        yield [
            'row' => 'A',
            'column' => 5,
            'rowFlowPosition' => 5,
            'columnFlowPosition' => 33,
        ];
        yield [
            'row' => 'B',
            'column' => 5,
            'rowFlowPosition' => 17,
            'columnFlowPosition' => 34,
        ];
        yield [
            'row' => 'C',
            'column' => 5,
            'rowFlowPosition' => 29,
            'columnFlowPosition' => 35,
        ];
        yield [
            'row' => 'D',
            'column' => 5,
            'rowFlowPosition' => 41,
            'columnFlowPosition' => 36,
        ];
        yield [
            'row' => 'E',
            'column' => 5,
            'rowFlowPosition' => 53,
            'columnFlowPosition' => 37,
        ];
        yield [
            'row' => 'F',
            'column' => 5,
            'rowFlowPosition' => 65,
            'columnFlowPosition' => 38,
        ];
        yield [
            'row' => 'G',
            'column' => 5,
            'rowFlowPosition' => 77,
            'columnFlowPosition' => 39,
        ];
        yield [
            'row' => 'H',
            'column' => 5,
            'rowFlowPosition' => 89,
            'columnFlowPosition' => 40,
        ];
        yield [
            'row' => 'A',
            'column' => 6,
            'rowFlowPosition' => 6,
            'columnFlowPosition' => 41,
        ];
        yield [
            'row' => 'B',
            'column' => 6,
            'rowFlowPosition' => 18,
            'columnFlowPosition' => 42,
        ];
        yield [
            'row' => 'C',
            'column' => 6,
            'rowFlowPosition' => 30,
            'columnFlowPosition' => 43,
        ];
        yield [
            'row' => 'D',
            'column' => 6,
            'rowFlowPosition' => 42,
            'columnFlowPosition' => 44,
        ];
        yield [
            'row' => 'E',
            'column' => 6,
            'rowFlowPosition' => 54,
            'columnFlowPosition' => 45,
        ];
        yield [
            'row' => 'F',
            'column' => 6,
            'rowFlowPosition' => 66,
            'columnFlowPosition' => 46,
        ];
        yield [
            'row' => 'G',
            'column' => 6,
            'rowFlowPosition' => 78,
            'columnFlowPosition' => 47,
        ];
        yield [
            'row' => 'H',
            'column' => 6,
            'rowFlowPosition' => 90,
            'columnFlowPosition' => 48,
        ];
        yield [
            'row' => 'A',
            'column' => 7,
            'rowFlowPosition' => 7,
            'columnFlowPosition' => 49,
        ];
        yield [
            'row' => 'B',
            'column' => 7,
            'rowFlowPosition' => 19,
            'columnFlowPosition' => 50,
        ];
        yield [
            'row' => 'C',
            'column' => 7,
            'rowFlowPosition' => 31,
            'columnFlowPosition' => 51,
        ];
        yield [
            'row' => 'D',
            'column' => 7,
            'rowFlowPosition' => 43,
            'columnFlowPosition' => 52,
        ];
        yield [
            'row' => 'E',
            'column' => 7,
            'rowFlowPosition' => 55,
            'columnFlowPosition' => 53,
        ];
        yield [
            'row' => 'F',
            'column' => 7,
            'rowFlowPosition' => 67,
            'columnFlowPosition' => 54,
        ];
        yield [
            'row' => 'G',
            'column' => 7,
            'rowFlowPosition' => 79,
            'columnFlowPosition' => 55,
        ];
        yield [
            'row' => 'H',
            'column' => 7,
            'rowFlowPosition' => 91,
            'columnFlowPosition' => 56,
        ];
        yield [
            'row' => 'A',
            'column' => 8,
            'rowFlowPosition' => 8,
            'columnFlowPosition' => 57,
        ];
        yield [
            'row' => 'B',
            'column' => 8,
            'rowFlowPosition' => 20,
            'columnFlowPosition' => 58,
        ];
        yield [
            'row' => 'C',
            'column' => 8,
            'rowFlowPosition' => 32,
            'columnFlowPosition' => 59,
        ];
        yield [
            'row' => 'D',
            'column' => 8,
            'rowFlowPosition' => 44,
            'columnFlowPosition' => 60,
        ];
        yield [
            'row' => 'E',
            'column' => 8,
            'rowFlowPosition' => 56,
            'columnFlowPosition' => 61,
        ];
        yield [
            'row' => 'F',
            'column' => 8,
            'rowFlowPosition' => 68,
            'columnFlowPosition' => 62,
        ];
        yield [
            'row' => 'G',
            'column' => 8,
            'rowFlowPosition' => 80,
            'columnFlowPosition' => 63,
        ];
        yield [
            'row' => 'H',
            'column' => 8,
            'rowFlowPosition' => 92,
            'columnFlowPosition' => 64,
        ];
        yield [
            'row' => 'A',
            'column' => 9,
            'rowFlowPosition' => 9,
            'columnFlowPosition' => 65,
        ];
        yield [
            'row' => 'B',
            'column' => 9,
            'rowFlowPosition' => 21,
            'columnFlowPosition' => 66,
        ];
        yield [
            'row' => 'C',
            'column' => 9,
            'rowFlowPosition' => 33,
            'columnFlowPosition' => 67,
        ];
        yield [
            'row' => 'D',
            'column' => 9,
            'rowFlowPosition' => 45,
            'columnFlowPosition' => 68,
        ];
        yield [
            'row' => 'E',
            'column' => 9,
            'rowFlowPosition' => 57,
            'columnFlowPosition' => 69,
        ];
        yield [
            'row' => 'F',
            'column' => 9,
            'rowFlowPosition' => 69,
            'columnFlowPosition' => 70,
        ];
        yield [
            'row' => 'G',
            'column' => 9,
            'rowFlowPosition' => 81,
            'columnFlowPosition' => 71,
        ];
        yield [
            'row' => 'H',
            'column' => 9,
            'rowFlowPosition' => 93,
            'columnFlowPosition' => 72,
        ];
        yield [
            'row' => 'A',
            'column' => 10,
            'rowFlowPosition' => 10,
            'columnFlowPosition' => 73,
        ];
        yield [
            'row' => 'B',
            'column' => 10,
            'rowFlowPosition' => 22,
            'columnFlowPosition' => 74,
        ];
        yield [
            'row' => 'C',
            'column' => 10,
            'rowFlowPosition' => 34,
            'columnFlowPosition' => 75,
        ];
        yield [
            'row' => 'D',
            'column' => 10,
            'rowFlowPosition' => 46,
            'columnFlowPosition' => 76,
        ];
        yield [
            'row' => 'E',
            'column' => 10,
            'rowFlowPosition' => 58,
            'columnFlowPosition' => 77,
        ];
        yield [
            'row' => 'F',
            'column' => 10,
            'rowFlowPosition' => 70,
            'columnFlowPosition' => 78,
        ];
        yield [
            'row' => 'G',
            'column' => 10,
            'rowFlowPosition' => 82,
            'columnFlowPosition' => 79,
        ];
        yield [
            'row' => 'H',
            'column' => 10,
            'rowFlowPosition' => 94,
            'columnFlowPosition' => 80,
        ];
        yield [
            'row' => 'A',
            'column' => 11,
            'rowFlowPosition' => 11,
            'columnFlowPosition' => 81,
        ];
        yield [
            'row' => 'B',
            'column' => 11,
            'rowFlowPosition' => 23,
            'columnFlowPosition' => 82,
        ];
        yield [
            'row' => 'C',
            'column' => 11,
            'rowFlowPosition' => 35,
            'columnFlowPosition' => 83,
        ];
        yield [
            'row' => 'D',
            'column' => 11,
            'rowFlowPosition' => 47,
            'columnFlowPosition' => 84,
        ];
        yield [
            'row' => 'E',
            'column' => 11,
            'rowFlowPosition' => 59,
            'columnFlowPosition' => 85,
        ];
        yield [
            'row' => 'F',
            'column' => 11,
            'rowFlowPosition' => 71,
            'columnFlowPosition' => 86,
        ];
        yield [
            'row' => 'G',
            'column' => 11,
            'rowFlowPosition' => 83,
            'columnFlowPosition' => 87,
        ];
        yield [
            'row' => 'H',
            'column' => 11,
            'rowFlowPosition' => 95,
            'columnFlowPosition' => 88,
        ];
        yield [
            'row' => 'A',
            'column' => 12,
            'rowFlowPosition' => 12,
            'columnFlowPosition' => 89,
        ];
        yield [
            'row' => 'B',
            'column' => 12,
            'rowFlowPosition' => 24,
            'columnFlowPosition' => 90,
        ];
        yield [
            'row' => 'C',
            'column' => 12,
            'rowFlowPosition' => 36,
            'columnFlowPosition' => 91,
        ];
        yield [
            'row' => 'D',
            'column' => 12,
            'rowFlowPosition' => 48,
            'columnFlowPosition' => 92,
        ];
        yield [
            'row' => 'E',
            'column' => 12,
            'rowFlowPosition' => 60,
            'columnFlowPosition' => 93,
        ];
        yield [
            'row' => 'F',
            'column' => 12,
            'rowFlowPosition' => 72,
            'columnFlowPosition' => 94,
        ];
        yield [
            'row' => 'G',
            'column' => 12,
            'rowFlowPosition' => 84,
            'columnFlowPosition' => 95,
        ];
        yield [
            'row' => 'H',
            'column' => 12,
            'rowFlowPosition' => 96,
            'columnFlowPosition' => 96,
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataProvider12Well')]
    /** @dataProvider dataProvider12Well */
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

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidRowsOrColumns')]
    /** @dataProvider invalidRowsOrColumns */
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

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidPositions')]
    /** @dataProvider invalidPositions */
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

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidCoordinates')]
    /** @dataProvider invalidCoordinates */
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
}

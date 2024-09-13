<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate;

use MLL\Utils\Microplate\CoordinateSystem;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\CoordinateSystem1x1;
use MLL\Utils\Microplate\CoordinateSystem2x16;
use MLL\Utils\Microplate\CoordinateSystem4x3;
use MLL\Utils\Microplate\CoordinateSystem6x4;
use MLL\Utils\Microplate\CoordinateSystem8x6;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CoordinateSystemTest extends TestCase
{
    /** @dataProvider firstLast */
    #[DataProvider('firstLast')]
    public function testFirstLast(CoordinateSystem $coordinateSystem, string $expectedFirst, string $expectedLast): void
    {
        $actualFirst = $coordinateSystem->first();
        self::assertSame($expectedFirst, $actualFirst->toString());
        self::assertSame($coordinateSystem, $actualFirst->coordinateSystem);

        $actualLast = $coordinateSystem->last();
        self::assertSame($expectedLast, $actualLast->toString());
        self::assertSame($coordinateSystem, $actualLast->coordinateSystem);
    }

    /** @return iterable<array{CoordinateSystem, string, string}> */
    public static function firstLast(): iterable
    {
        yield '1x1' => [new CoordinateSystem1x1(), 'A1', 'A1'];
        yield '2x16' => [new CoordinateSystem2x16(), 'A1', 'P2'];
        yield '4x3' => [new CoordinateSystem4x3(), 'A1', 'C4'];
        yield '6x4' => [new CoordinateSystem6x4(), 'A1', 'D6'];
        yield '8x6' => [new CoordinateSystem8x6(), 'A1', 'F8'];
        yield '12x8' => [new CoordinateSystem12x8(), 'A1', 'H12'];
    }

    public function testPositionsCount(): void
    {
        self::assertSame(CoordinateSystem1x1::POSITIONS_COUNT, (new CoordinateSystem1x1())->positionsCount());
        self::assertSame(CoordinateSystem2x16::POSITIONS_COUNT, (new CoordinateSystem2x16())->positionsCount());
        self::assertSame(CoordinateSystem4x3::POSITIONS_COUNT, (new CoordinateSystem4x3())->positionsCount());
        self::assertSame(CoordinateSystem6x4::POSITIONS_COUNT, (new CoordinateSystem6x4())->positionsCount());
        self::assertSame(CoordinateSystem8x6::POSITIONS_COUNT, (new CoordinateSystem8x6())->positionsCount());
        self::assertSame(CoordinateSystem12x8::POSITIONS_COUNT, (new CoordinateSystem12x8())->positionsCount());
    }
}

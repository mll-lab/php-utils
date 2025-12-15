<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate;

use MLL\Utils\Microplate\CoordinateSystem;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\CoordinateSystem1x1;
use MLL\Utils\Microplate\CoordinateSystem2x16;
use MLL\Utils\Microplate\CoordinateSystem2x16NoJ;
use MLL\Utils\Microplate\CoordinateSystem4x3;
use MLL\Utils\Microplate\CoordinateSystem6x4;
use MLL\Utils\Microplate\CoordinateSystem6x8;
use MLL\Utils\Microplate\CoordinateSystem8x6;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CoordinateSystemTest extends TestCase
{
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
        yield '2x16NoJ' => [new CoordinateSystem2x16NoJ(), 'A1', 'Q2'];
        yield '4x3' => [new CoordinateSystem4x3(), 'A1', 'C4'];
        yield '6x4' => [new CoordinateSystem6x4(), 'A1', 'D6'];
        yield '6x8' => [new CoordinateSystem6x8(), 'A1', 'H6'];
        yield '8x6' => [new CoordinateSystem8x6(), 'A1', 'F8'];
        yield '12x8' => [new CoordinateSystem12x8(), 'A1', 'H12'];
    }

    public function testPositionsCount(): void
    {
        self::assertSame(CoordinateSystem1x1::POSITIONS_COUNT, (new CoordinateSystem1x1())->positionsCount());
        self::assertSame(CoordinateSystem2x16::POSITIONS_COUNT, (new CoordinateSystem2x16())->positionsCount());
        self::assertSame(CoordinateSystem2x16NoJ::POSITIONS_COUNT, (new CoordinateSystem2x16NoJ())->positionsCount());
        self::assertSame(CoordinateSystem4x3::POSITIONS_COUNT, (new CoordinateSystem4x3())->positionsCount());
        self::assertSame(CoordinateSystem6x4::POSITIONS_COUNT, (new CoordinateSystem6x4())->positionsCount());
        self::assertSame(CoordinateSystem6x8::POSITIONS_COUNT, (new CoordinateSystem6x8())->positionsCount());
        self::assertSame(CoordinateSystem8x6::POSITIONS_COUNT, (new CoordinateSystem8x6())->positionsCount());
        self::assertSame(CoordinateSystem12x8::POSITIONS_COUNT, (new CoordinateSystem12x8())->positionsCount());
    }

    public function testEquals(): void
    {
        $coordinateSystem6x8 = new CoordinateSystem6x8();
        self::assertTrue($coordinateSystem6x8->equals($coordinateSystem6x8));

        $coordinateSystem6x8AnotherInstance = new CoordinateSystem6x8();
        self::assertTrue($coordinateSystem6x8->equals($coordinateSystem6x8AnotherInstance));
        self::assertTrue($coordinateSystem6x8AnotherInstance->equals($coordinateSystem6x8));

        $coordinateSystem6x8Child = new class() extends CoordinateSystem6x8 {};
        self::assertTrue($coordinateSystem6x8->equals($coordinateSystem6x8Child));
        self::assertTrue($coordinateSystem6x8Child->equals($coordinateSystem6x8));

        $coordinateSystem8x8ModifiedChild = new class() extends CoordinateSystem6x8 {
            public function columns(): array
            {
                return range(1, 8);
            }
        };
        self::assertFalse($coordinateSystem6x8->equals($coordinateSystem8x8ModifiedChild));
        self::assertFalse($coordinateSystem8x8ModifiedChild->equals($coordinateSystem6x8));

        $coordinateSystem8x6 = new CoordinateSystem8x6();
        self::assertFalse($coordinateSystem6x8->equals($coordinateSystem8x6));
        self::assertFalse($coordinateSystem8x6->equals($coordinateSystem6x8));
    }
}

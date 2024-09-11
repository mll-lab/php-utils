<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Microplate;

use MLL\Utils\Microplate\CoordinateSystem;
use MLL\Utils\Microplate\CoordinateSystem12Well;
use MLL\Utils\Microplate\CoordinateSystem2x16;
use MLL\Utils\Microplate\CoordinateSystem48Well;
use MLL\Utils\Microplate\CoordinateSystem96Well;
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
        yield [new CoordinateSystem12Well(), 'A1', 'C4'];
        yield [new CoordinateSystem48Well(), 'A1', 'F8'];
        yield [new CoordinateSystem96Well(), 'A1', 'H12'];
        yield [new CoordinateSystem2x16(), 'A1', 'P2'];
    }

    public function testPositionsCount(): void
    {
        self::assertSame(CoordinateSystem12Well::POSITIONS_COUNT, (new CoordinateSystem12Well())->positionsCount());
        self::assertSame(CoordinateSystem48Well::POSITIONS_COUNT, (new CoordinateSystem48Well())->positionsCount());
        self::assertSame(CoordinateSystem96Well::POSITIONS_COUNT, (new CoordinateSystem96Well())->positionsCount());
        self::assertSame(CoordinateSystem2x16::POSITIONS_COUNT, (new CoordinateSystem2x16())->positionsCount());
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\AdvancedCommands;

use MLL\Utils\Tecan\AdvancedCommands\Volumes;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VolumesTest extends TestCase
{
    /** @return iterable<array{0: array<int, float|int>, 1: string, 2: int}> */
    public static function validVolumesProvider(): iterable
    {
        yield [[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], '0,0,0,0,0,0,0,0,0,0,0,0', 0];
        yield [[1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], '"1",0,0,0,0,0,0,0,0,0,0,0', 1];
        yield [[1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], '"1","2",0,0,0,0,0,0,0,0,0,0', 3];
        yield [[1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0], '"1",0,"2",0,0,0,0,0,0,0,0,0', 5];
        yield [[1, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0], '"1",0,0,"2",0,0,0,0,0,0,0,0', 9];

        yield [[1, 0, 2.5, 0, 0, 3, 0, 4, 0, 0, 0, 0], '"1",0,"2.5",0,0,"3",0,"4",0,0,0,0', 165];
        yield [[1, 2, 3, 4, 5, 6, 7, 8, 0, 0, 0, 0], '"1","2","3","4","5","6","7","8",0,0,0,0', 255];
    }

    /** @dataProvider validVolumesProvider
     * @param array{
     *      0:float|int,
     *      1:float|int,
     *      2:float|int,
     *      3:float|int,
     *      4:float|int,
     *      5:float|int,
     *      6:float|int,
     *      7:float|int,
     *      8:float|int,
     *      9:float|int,
     *      10:float|int,
     *      11:float|int,
     *  } $volumes
     */
    #[DataProvider('validVolumesProvider')]
    public function testVolumesStringAndTipMask(array $volumes, string $expectedString, int $expectedMask): void
    {
        $volumesObj = new Volumes($volumes);
        self::assertSame($expectedString, $volumesObj->volumeString());
        self::assertSame($expectedMask, $volumesObj->tipMask());
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycle;
use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class OverrideCycleTest extends TestCase
{
    public function testFromString(): void
    {
        $overrideCycle = OverrideCycle::fromString('R1:Y251', IndexOrientation::FORWARD());
        self::assertCount(1, $overrideCycle->cycleTypeWithCountList);
        self::assertSame(251, $overrideCycle->cycleTypeWithCountList[0]->count);

        $overrideCycle = OverrideCycle::fromString('I2:I6', IndexOrientation::FORWARD());
        self::assertCount(1, $overrideCycle->cycleTypeWithCountList);
        self::assertSame(6, $overrideCycle->cycleTypeWithCountList[0]->count);

        $overrideCycle = OverrideCycle::fromString('R1:U5N2Y94', IndexOrientation::FORWARD());
        self::assertCount(3, $overrideCycle->cycleTypeWithCountList);
        self::assertSame(5, $overrideCycle->cycleTypeWithCountList[0]->count);
        self::assertSame(2, $overrideCycle->cycleTypeWithCountList[1]->count);
        self::assertSame(94, $overrideCycle->cycleTypeWithCountList[2]->count);
    }

    /** @dataProvider provideCasesForFillUpTest */
    #[DataProvider('provideCasesForFillUpTest')]
    public function testFillUp(string $overrideCycleAsString, int $diff, IndexOrientation $indexOrientation, string $expected): void
    {
        $overrideCycle = OverrideCycle::fromString($overrideCycleAsString, $indexOrientation);
        $total = $overrideCycle->sumCountOfAllCycles() + $diff;

        self::assertSame(
            $expected,
            $overrideCycle
                ->fillUpTo($total)
                ->toString()
        );
    }

    public function testFillUpDoesNotMutateOriginal(): void
    {
        $overrideCycle = OverrideCycle::fromString('R1:U5N2Y94', IndexOrientation::FORWARD());
        $originalSum = $overrideCycle->sumCountOfAllCycles();

        $overrideCycle->fillUpTo($originalSum + 4);

        self::assertSame($originalSum, $overrideCycle->sumCountOfAllCycles());
        self::assertCount(3, $overrideCycle->cycleTypeWithCountList);
    }

    /** @return iterable<string, array{string, int, IndexOrientation, string}> */
    public static function provideCasesForFillUpTest(): iterable
    {
        yield 'R1 diff in length' => [
            'R1:U5N2Y94', 4, IndexOrientation::FORWARD(), 'R1:U5N2Y94N4',
        ];
        yield 'I1 diff in length' => [
            'I1:I6', 2, IndexOrientation::FORWARD(), 'I1:I6N2',
        ];
        yield 'R1 UMI diff in length' => [
            'R1:U4N2Y98', 1, IndexOrientation::FORWARD(), 'R1:U4N2Y98N1',
        ];
        yield 'R2 diff in length' => [
            'R2:Y241', 10, IndexOrientation::FORWARD(), 'R2:Y241N10',
        ];
        yield 'I2 diff in length - IndexOrientation Forward' => [
            'I2:I6', 2, IndexOrientation::FORWARD(), 'I2:N2I6',
        ];
        yield 'I2 diff in length - IndexOrientation Reverse' => [
            'I2:I6', 2, IndexOrientation::REVERSE(), 'I2:I6N2',
        ];
    }
}

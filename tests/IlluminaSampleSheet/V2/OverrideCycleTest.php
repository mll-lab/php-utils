<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\NucleotideType;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycle;
use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class OverrideCycleTest extends TestCase
{
    public function testFromString(): void
    {
        $overrideCycle = OverrideCycle::fromString('Y251', IndexOrientation::FORWARD());
        self::assertCount(1, $overrideCycle->cycleTypeWithCountList);
        self::assertSame(251, $overrideCycle->cycleTypeWithCountList[0]->count);

        $overrideCycle = OverrideCycle::fromString('I6', IndexOrientation::FORWARD());
        self::assertCount(1, $overrideCycle->cycleTypeWithCountList);
        self::assertSame(6, $overrideCycle->cycleTypeWithCountList[0]->count);

        $overrideCycle = OverrideCycle::fromString('U5N2Y94', IndexOrientation::FORWARD());
        self::assertCount(3, $overrideCycle->cycleTypeWithCountList);
        self::assertSame(5, $overrideCycle->cycleTypeWithCountList[0]->count);
        self::assertSame(2, $overrideCycle->cycleTypeWithCountList[1]->count);
        self::assertSame(94, $overrideCycle->cycleTypeWithCountList[2]->count);
    }

    /**
     * @param array{string, NucleotideType} $cycleStringAndNucleotideType
     *
     * @dataProvider provideCasesForFillUpTest
     */
    #[DataProvider('provideCasesForFillUpTest')]
    public function testFillUp(array $cycleStringAndNucleotideType, int $diff, IndexOrientation $indexOrientation, string $expected): void
    {
        [$cycleString, $nucleotideType] = $cycleStringAndNucleotideType;
        $overrideCycle = OverrideCycle::fromString($cycleString, $indexOrientation);
        $total = $overrideCycle->sumCountOfAllCycles() + $diff;

        self::assertSame(
            $expected,
            $overrideCycle
                ->fillUpTo($total, $nucleotideType)
                ->toString()
        );
    }

    public function testFillUpDoesNotMutateOriginal(): void
    {
        $overrideCycle = OverrideCycle::fromString('U5N2Y94', IndexOrientation::FORWARD());
        $originalSum = $overrideCycle->sumCountOfAllCycles();

        $overrideCycle->fillUpTo($originalSum + 4, new NucleotideType(NucleotideType::R1));

        self::assertSame($originalSum, $overrideCycle->sumCountOfAllCycles());
        self::assertCount(3, $overrideCycle->cycleTypeWithCountList);
    }

    /** @return iterable<string, array{array{string, NucleotideType}, int, IndexOrientation, string}> */
    public static function provideCasesForFillUpTest(): iterable
    {
        yield 'R1 diff in length' => [
            ['U5N2Y94', new NucleotideType(NucleotideType::R1)], 4, IndexOrientation::FORWARD(), 'U5N2Y94N4',
        ];
        yield 'I1 diff in length' => [
            ['I6', new NucleotideType(NucleotideType::I1)], 2, IndexOrientation::FORWARD(), 'I6N2',
        ];
        yield 'R1 UMI diff in length' => [
            ['U4N2Y98', new NucleotideType(NucleotideType::R1)], 1, IndexOrientation::FORWARD(), 'U4N2Y98N1',
        ];
        yield 'R2 diff in length' => [
            ['Y241', new NucleotideType(NucleotideType::R2)], 10, IndexOrientation::FORWARD(), 'Y241N10',
        ];
        yield 'I2 diff in length - IndexOrientation Forward' => [
            ['I6', new NucleotideType(NucleotideType::I2)], 2, IndexOrientation::FORWARD(), 'N2I6',
        ];
        yield 'I2 diff in length - IndexOrientation Reverse' => [
            ['I6', new NucleotideType(NucleotideType::I2)], 2, IndexOrientation::REVERSE(), 'I6N2',
        ];
    }
}

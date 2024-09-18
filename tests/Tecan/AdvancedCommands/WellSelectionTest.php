<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\AdvancedCommands;

use MLL\Utils\Tecan\AdvancedCommands\WellSelection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class WellSelectionTest extends TestCase
{
    /** @return iterable<array{0: int, 1: int, 2: array<int>, 3: string}> */
    public static function wellSelectionProvider(): iterable
    {
        yield 'returns0000WhenXWellsIsZero' => [0, 5, [], '0000'];
        yield 'returns0000WhenYWellsIsZero' => [5, 0, [], '0000'];
        yield 'A1 pos 1' => [12, 8, [1], '0C0810000000000000'];
        yield 'B1 pos 2' => [12, 8, [2], '0C0820000000000000'];
        yield 'C1 pos 3' => [12, 8, [3], '0C0840000000000000'];
        yield 'D1 pos 4' => [12, 8, [4], '0C0880000000000000'];
        yield 'E1 pos 5' => [12, 8, [5], '0C08@0000000000000'];
        yield 'F1 pos 6' => [12, 8, [6], '0C08P0000000000000'];
        yield 'G1 pos 7' => [12, 8, [7], '0C08p0000000000000'];
        yield 'A1  + E1 pos 1 + 5' => [12, 8, [1, 5], '0C08A0000000000000'];
        yield 'no wells selected' => [12, 8, [], '0C0800000000000000'];
    }

    /**
     * @dataProvider wellSelectionProvider
     *
     * @param array<int, int> $positions
     */
    #[DataProvider('wellSelectionProvider')]
    public function testWellSelection(int $xWells, int $yWells, array $positions, string $expected): void
    {
        $wellSelection = new WellSelection($xWells, $yWells, $positions);
        self::assertEquals($expected, $wellSelection->toString());
    }

    /** @return iterable<array{0: array<int>, 1: int, 2: int, 3: array<int, array<int, int>>}> */
    public static function transformPositionsToSelFlagProvider(): iterable
    {
        yield [
            [1, 5], 12, 8, [
                [1, 0, 0, 0, 1, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
            ],
        ];
        yield [
            [8, 96], 12, 8, [
                [0, 0, 0, 0, 0, 0, 0],
                [1, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 1, 0, 0],
            ],
        ];
        yield [
            [15, 40], 12, 8, [
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [1, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 1, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0],
            ],
        ];
    }

    /**
     * @dataProvider transformPositionsToSelFlagProvider
     *
     * @param array<int> $positions
     * @param array<int, array<int, int>> $expected
     */
    #[DataProvider('transformPositionsToSelFlagProvider')]
    public function testTransformPositionsToSelFlag(array $positions, int $xWells, int $yWells, array $expected): void
    {
        self::assertEquals($expected, WellSelection::transformPositionsToSelFlag($positions, $xWells, $yWells));
    }
}

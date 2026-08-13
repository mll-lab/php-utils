<?php declare(strict_types=1);

namespace MLL\Utils\Tests\InterOp;

use MLL\Utils\InterOp\LaneResult;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LaneResultTest extends TestCase
{
    /** @dataProvider yieldsProvider */
    #[DataProvider('yieldsProvider')]
    public function testConvertsYieldToKilobases(string $gigabases, int $expectedKilobases): void
    {
        $laneResult = LaneResult::fromInterOpRow([
            'Density' => '1234 +/- 56',
            'Cluster PF' => '92.34 +/- 1.23',
            'Aligned' => '28.66 +/- 0.12',
            'Error' => '0.27 +/- 0.01',
            'Intensity C1' => '4321 +/- 0',
            'Legacy Phasing/Prephasing Rate' => '0.123 / 0.045',
            'Reads' => '1.23',
            'Reads PF' => '1.13',
            '%>=Q30' => '93.21',
            'Yield' => $gigabases,
        ]);

        self::assertSame($expectedKilobases, $laneResult->yield);
    }

    /** @return iterable<array{string, int}> */
    public static function yieldsProvider(): iterable
    {
        yield ['8.04', 8040000];
        yield ['1.49', 1490000];
        yield ['0.02', 20000];
        yield ['0', 0];
    }
}

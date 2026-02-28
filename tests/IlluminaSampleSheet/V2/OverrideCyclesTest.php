<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycleCounter;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycles;
use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class OverrideCyclesTest extends TestCase
{
    /**
     * @param Collection<int, string> $overrideCyclesList
     *
     * @dataProvider provideCasesForFromStringToString
     */
    #[DataProvider('provideCasesForFromStringToString')]
    public function testFromStringToString(string $overrideCyclesAsString, Collection $overrideCyclesList, IndexOrientation $indexOrientation, string $expected): void
    {
        $overrideCycleCounter = new OverrideCycleCounter(
            $overrideCyclesList->map(fn (string $overrideCycleAsString): OverrideCycles => OverrideCycles::fromString($overrideCycleAsString, $indexOrientation))
        );
        $overrideCycles = OverrideCycles::fromString($overrideCyclesAsString, $indexOrientation);
        self::assertSame($expected, $overrideCycles->toString($overrideCycleCounter));
    }

    /** @return iterable<string, array{string, Collection<int, string>, IndexOrientation, string}> */
    public static function provideCasesForFromStringToString(): iterable
    {
        yield 'L1 diff in length' => [
            'U5N2Y94;I6;I8;Y251',
            new Collection(['U5N2Y94;I6;I8;Y251', 'U5N2Y94;I8;I8;Y251']),
            IndexOrientation::FORWARD(),
            'U5N2Y94;I6N2;I8;Y251',
        ];

        yield 'R1 read diff in length' => [
            'U5N2Y94;I8;I8;Y251',
            new Collection(['U5N2Y94;I8;I8;Y251', 'U5N2Y98;I8;I8;Y251']),
            IndexOrientation::FORWARD(),
            'U5N2Y94N4;I8;I8;Y251',
        ];

        yield 'R1 UMI diff in length' => [
            'U4N2Y98;I8;I8;Y251',
            new Collection(['U4N2Y98;I8;I8;Y251', 'U5N2Y98;I6;I8;Y251']),
            IndexOrientation::FORWARD(),
            'U4N2Y98N1;I8;I8;Y251',
        ];

        yield 'R2 read diff in length' => [
            'U5N2Y98;I8;I8;Y241',
            new Collection(['U5N2Y98;I8;I8;Y241', 'U5N2Y98;I8;I8;Y251']),
            IndexOrientation::FORWARD(),
            'U5N2Y98;I8;I8;Y241N10',
        ];

        yield 'I2 Changed - Index Forward' => [
            'U5N2Y98;I8;I6;Y251',
            new Collection(['U5N2Y98;I8;I6;Y251', 'U5N2Y98;I8;I8;Y251']),
            IndexOrientation::FORWARD(),
            'U5N2Y98;I8;N2I6;Y251',
        ];

        yield 'I2 Changed - Index Reverse' => [
            'U5N2Y98;I8;I6;Y251',
            new Collection(['U5N2Y98;I8;I6;Y251', 'U5N2Y98;I8;I8;Y251']),
            IndexOrientation::REVERSE(),
            'U5N2Y98;I8;I6N2;Y251',
        ];

        yield 'R1 changed, I1 Changed, I2 Changed, R2 Changed' => [
            'U4N2Y98;I6;I6;Y251',
            new Collection(['U4N2Y98;I6;I8;Y251', 'U5N2Y100;I8;I6;Y241']),
            IndexOrientation::REVERSE(),
            'U4N2Y98N3;I6N2;I6N2;Y251',
        ];
    }
}

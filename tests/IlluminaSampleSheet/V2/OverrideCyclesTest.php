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
     * @dataProvider provideCasesForFromStringToString
     */
    #[DataProvider('provideCasesForFromStringToString')]
    public function testFromStringToString(string $overrideCyclesAsString, Collection $overrideCyclesList, IndexOrientation $indexOrientation, string $expected): void
    {
        $overrideCycleCounter = new OverrideCycleCounter(
            $overrideCyclesList->map(fn(string $overrideCycleAsString): OverrideCycles => OverrideCycles::fromString($overrideCycleAsString, $indexOrientation))
        );
        $overrideCycles = OverrideCycles::fromString($overrideCyclesAsString, $indexOrientation);
        self::assertSame($expected, $overrideCycles->toString($overrideCycleCounter));
    }

    /**
     * @return iterable<string, array{
     *    overrideCyclesAsString: string,
     *    overrideCyclesList: Collection<int, string>,
     *    indexOrientation: IndexOrientation,
     *    expected: string
     * }>
     */
    public static function provideCasesForFromStringToString(): iterable
    {
        yield "L1 diff in length" => [
            "overrideCyclesAsString" => 'R1:U5N2Y94;I1:I6;I2:I8;R2:Y251',
            'overrideCyclesList' => new Collection(['R1:U5N2Y94;I1:I6;I2:I8;R2:Y251','R1:U5N2Y94;I1:I8;I2:I8;R2:Y251']),
            'indexOrientation' => IndexOrientation::FORWARD,
            "expected" => 'R1:U5N2Y94;I1:I6N2;I2:I8;R2:Y251'
        ];

        yield "R1 read diff in length" => [
            "overrideCyclesAsString" => 'R1:U5N2Y94;I1:I8;I2:I8;R2:Y251',
            'overrideCyclesList' => new Collection(['R1:U5N2Y94;I1:I8;I2:I8;R2:Y251','R1:U5N2Y98;I1:I8;I2:I8;R2:Y251']),
            'indexOrientation' => IndexOrientation::FORWARD,
            "expected" => 'R1:U5N2Y94N4;I1:I8;I2:I8;R2:Y251'
        ];

        yield "R1 UMI diff in length" => [
            "overrideCyclesAsString" => 'R1:U4N2Y98;I1:I8;I2:I8;R2:Y251',
            'overrideCyclesList' => new Collection(['R1:U4N2Y98;I1:I8;I2:I8;R2:Y251','R1:U5N2Y98;I1:I6;I2:I8;R2:Y251']),
            'indexOrientation' => IndexOrientation::FORWARD,
            "expected" => 'R1:U4N2Y98N1;I1:I8;I2:I8;R2:Y251'
        ];

        yield "R2 read diff in length" => [
            "overrideCyclesAsString" => 'R1:U5N2Y98;I1:I8;I2:I8;R2:Y241',
            'overrideCyclesList' => new Collection(['R1:U5N2Y98;I1:I8;I2:I8;R2:Y241','R1:U5N2Y98;I1:I8;I2:I8;R2:Y251']),
            'indexOrientation' => IndexOrientation::FORWARD,
            "expected" => 'R1:U5N2Y98;I1:I8;I2:I8;R2:Y241N10'
        ];

        yield "I2 Changed - Index Forward" => [
            "overrideCyclesAsString" => 'R1:U5N2Y98;I1:I8;I2:I6;R2:Y251',
            'overrideCyclesList' => new Collection(['R1:U5N2Y98;I1:I8;I2:I6;R2:Y251','R1:U5N2Y98;I1:I8;I2:I8;R2:Y251']),
            'indexOrientation' => IndexOrientation::FORWARD,
            "expected" => 'R1:U5N2Y98;I1:I8;I2:N2I6;R2:Y251'
        ];

        yield "I2 Changed - Index Reverse" => [
            "overrideCyclesAsString" => 'R1:U5N2Y98;I1:I8;I2:I6;R2:Y251',
            'overrideCyclesList' => new Collection(['R1:U5N2Y98;I1:I8;I2:I6;R2:Y251','R1:U5N2Y98;I1:I8;I2:I8;R2:Y251']),
            'indexOrientation' => IndexOrientation::REVERSE,
            "expected" => 'R1:U5N2Y98;I1:I8;I2:I6N2;R2:Y251'
        ];

        yield "R1 changed, I1 Changed, I2 Changed, R2 Changed" => [
            "overrideCyclesAsString" => 'R1:U4N2Y98;I1:I6;I2:I6;R2:Y251',
            'overrideCyclesList' => new Collection(['R1:U4N2Y98;I1:I6;I2:I8;R2:Y251','R1:U5N2Y100;I1:I8;I2:I6;R2:Y241']),
            'indexOrientation' => IndexOrientation::REVERSE,
            "expected" => 'R1:U4N2Y98N3;I1:I6N2;I2:I6N2;R2:Y251'
        ];
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use Illuminate\Support\Collection;
use MLL\Utils\Flowcells\NovaSeqX1_5B;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclSample;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycles;
use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;
use MLL\Utils\IlluminaSampleSheet\V2\Sections\BclConvertDataSection;
use PHPUnit\Framework\TestCase;

final class BclConvertDataSectionTest extends TestCase
{
    public function testOmitsBarcodeMismatchesIndex2ColumnWhenAllNull(): void
    {
        $indexOrientation = IndexOrientation::FORWARD();

        $bclSample0 = new BclSample(
            new NovaSeqX1_5B([1]),
            'Sample1',
            'Index1',
            'Index2',
            OverrideCycles::fromString('Y151;I8;I8;Y151', $indexOrientation),
            'Adapter1',
            'Adapter2',
            '0',
            null
        );

        $bclSample1 = new BclSample(
            new NovaSeqX1_5B([2]),
            'Sample2',
            'Index3',
            'Index4',
            OverrideCycles::fromString('Y151;I8;I8;Y151', $indexOrientation),
            'Adapter3',
            'Adapter4',
            '1',
            null
        );

        $section = new BclConvertDataSection(new Collection([$bclSample0, $bclSample1]));
        $result = $section->convertSectionToString();

        $expected = <<<'CSV'
            Lane,Sample_ID,Index,Index2,OverrideCycles,AdapterRead1,AdapterRead2,BarcodeMismatchesIndex1
            1,Sample1,Index1,Index2,Y151;I8;I8;Y151,Adapter1,Adapter2,0
            2,Sample2,Index3,Index4,Y151;I8;I8;Y151,Adapter3,Adapter4,1

            CSV;
        self::assertSame($expected, $result);
    }

    public function testIncludesBarcodeMismatchesIndex2ColumnWhenAllSet(): void
    {
        $indexOrientation = IndexOrientation::FORWARD();

        $bclSample0 = new BclSample(
            new NovaSeqX1_5B([1]),
            'Sample1',
            'Index1',
            'Index2',
            OverrideCycles::fromString('Y151;I8;I8;Y151', $indexOrientation),
            'Adapter1',
            'Adapter2',
            '0',
            '0'
        );

        $bclSample1 = new BclSample(
            new NovaSeqX1_5B([2]),
            'Sample2',
            'Index3',
            'Index4',
            OverrideCycles::fromString('Y151;I8;I8;Y151', $indexOrientation),
            'Adapter3',
            'Adapter4',
            '1',
            '1'
        );

        $section = new BclConvertDataSection(new Collection([$bclSample0, $bclSample1]));
        $result = $section->convertSectionToString();

        $expected = <<<'CSV'
            Lane,Sample_ID,Index,Index2,OverrideCycles,AdapterRead1,AdapterRead2,BarcodeMismatchesIndex1,BarcodeMismatchesIndex2
            1,Sample1,Index1,Index2,Y151;I8;I8;Y151,Adapter1,Adapter2,0,0
            2,Sample2,Index3,Index4,Y151;I8;I8;Y151,Adapter3,Adapter4,1,1

            CSV;
        self::assertSame($expected, $result);
    }

    public function testThrowsWhenBarcodeMismatchesIndex2IsInconsistent(): void
    {
        $indexOrientation = IndexOrientation::FORWARD();

        $bclSampleWithIndex2 = new BclSample(
            new NovaSeqX1_5B([1]),
            'Sample1',
            'Index1',
            'Index2',
            OverrideCycles::fromString('Y151;I8;I8;Y151', $indexOrientation),
            'Adapter1',
            'Adapter2',
            '0',
            '0'
        );

        $bclSampleWithoutIndex2 = new BclSample(
            new NovaSeqX1_5B([2]),
            'Sample2',
            'Index3',
            'Index4',
            OverrideCycles::fromString('Y151;I8;I8;Y151', $indexOrientation),
            'Adapter3',
            'Adapter4',
            '1',
            null
        );

        $section = new BclConvertDataSection(new Collection([$bclSampleWithIndex2, $bclSampleWithoutIndex2]));

        $this->expectException(IlluminaSampleSheetException::class);
        $this->expectExceptionMessage('Either all or no samples must have a barcodeMismatchesIndex2.');
        $section->convertSectionToString();
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\BclSample;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\DataSection;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvert\OverrideCycles;
use PHPUnit\Framework\TestCase;

final class DataSectionTest extends TestCase
{
    public function testToString(): void
    {
        $dataSection = new DataSection();
        $overrideCycles = new OverrideCycles($dataSection, 'Y130', 'I8', 'I10', 'Y100');
        $dataSection->addSample(new BclSample(100, 'Sample1', 'Index1', $overrideCycles));

        $overrideCycles = new OverrideCycles($dataSection, 'Y100', 'I11', 'I7', 'Y151');
        $dataSection->addSample(new BclSample(101, 'Sample2', 'Index3', $overrideCycles));

        $expected = <<<'CSV'
[BCLConvert_Data]
Lane,Sample_ID,Index,OverrideCycles
100,Sample1,Index1,Y130;I8N3;I10;Y100N51
101,Sample2,Index3,Y100N30;I11;N3I7;Y151

CSV;
        self::assertSame($expected, $dataSection->convertSectionToString());
    }

    public function testThrowsExceptionIfDataSectionIsEmpty(): void
    {
        $dataSection = new DataSection();

        $this->expectException(IlluminaSampleSheetException::class);
        $this->expectExceptionMessage('At least one sample must be added to the DataSection.');
        $dataSection->convertSectionToString();
    }

    public function testToStringWithProject(): void
    {
        $dataSection = new DataSection();
        $overrideCycles = new OverrideCycles($dataSection, 'Y130', 'I8', 'I10', 'Y100');
        $bclSample = new BclSample(100, 'Sample1', 'Index1', $overrideCycles);
        $bclSample->project = 'foo';
        $dataSection->addSample($bclSample);

        $expected = <<<'CSV'
[BCLConvert_Data]
Lane,Sample_ID,Index,OverrideCycles,Project
100,Sample1,Index1,Y130;I8;I10;Y100,foo

CSV;

        self::assertSame($expected, $dataSection->convertSectionToString());
    }

    public function testThrowsExceptionForInvalidCycleFormat(): void
    {
        $dataSection = new DataSection();

        $this->expectException(IlluminaSampleSheetException::class);
        $this->expectExceptionMessage('Invalid Override Cycle Part');
        new OverrideCycles($dataSection, 'invalid', 'I8', null, null);
    }
}

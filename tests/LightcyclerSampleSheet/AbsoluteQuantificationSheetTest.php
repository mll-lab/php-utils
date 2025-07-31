<?php declare(strict_types=1);

namespace MLL\Utils\Tests\LightcyclerSampleSheet;

use Illuminate\Support\Collection;
use MLL\Utils\LightcyclerSampleSheet\AbsoluteQuantificationSample;
use MLL\Utils\LightcyclerSampleSheet\AbsoluteQuantificationSheet;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class AbsoluteQuantificationSheetTest extends TestCase
{
    public function testGenerateWithFakeData(): void
    {
        $samples = Collection::make([
            'A1' => new AbsoluteQuantificationSample('Standard_1', '485-520', 'FF0000', 'Standard', 1000, null),
            'B1' => new AbsoluteQuantificationSample('Standard_1', '485-520', 'FF0001', 'Standard', 1000, Coordinates::fromString('A1', new CoordinateSystem12x8())),
            'C1' => new AbsoluteQuantificationSample('Standard_2', '485-520', '00FF00', 'Standard', 100, null),
            'D1' => new AbsoluteQuantificationSample('Standard_2', '485-520', '00FF01', 'Standard', 100, Coordinates::fromString('C1', new CoordinateSystem12x8())),
            'E1' => new AbsoluteQuantificationSample('Sample_001', '485-520', '0000FF', 'Unknown', null, null),
            'F1' => new AbsoluteQuantificationSample('Sample_001', '485-520', '0000FE', 'Unknown', null, Coordinates::fromString('E1', new CoordinateSystem12x8())),
            'G1' => new AbsoluteQuantificationSample('Sample_002', '485-520', 'FFFF00', 'Unknown', null, null),
            'H1' => new AbsoluteQuantificationSample('Sample_002', '485-520', 'FFFF01', 'Unknown', null, Coordinates::fromString('G1', new CoordinateSystem12x8())),
            'A2' => new AbsoluteQuantificationSample('NTC', '485-520', '000000', 'Negative Control', null, null),
            'B2' => new AbsoluteQuantificationSample('NTC', '485-520', '000001', 'Negative Control', null, Coordinates::fromString('A2', new CoordinateSystem12x8())),
        ]);

        $sheet = new AbsoluteQuantificationSheet();
        $result = $sheet->generate($samples);

        $expected = <<<EOT
"General:Pos"\t"General:Sample Name"\t"General:Repl. Of"\t"General:Filt. Comb."\t"Sample Preferences:Color"\t"Abs Quant:Sample Type"\t"Abs Quant:Concentration"
A1\t"Standard_1"\t""\t485-520\t$00FF0000\t"Standard"\t1.00E3
B1\t"Standard_1"\t"A1"\t485-520\t$00FF0001\t"Standard"\t1.00E3
C1\t"Standard_2"\t""\t485-520\t$0000FF00\t"Standard"\t1.00E2
D1\t"Standard_2"\t"C1"\t485-520\t$0000FF01\t"Standard"\t1.00E2
E1\t"Sample_001"\t""\t485-520\t$000000FF\t"Unknown"\t
F1\t"Sample_001"\t"E1"\t485-520\t$000000FE\t"Unknown"\t
G1\t"Sample_002"\t""\t485-520\t$00FFFF00\t"Unknown"\t
H1\t"Sample_002"\t"G1"\t485-520\t$00FFFF01\t"Unknown"\t
A2\t"NTC"\t""\t485-520\t$00000000\t"Negative Control"\t
B2\t"NTC"\t"A2"\t485-520\t$00000001\t"Negative Control"\t

EOT;

        self::assertSame(StringUtil::normalizeLineEndings($expected), $result);
    }
}

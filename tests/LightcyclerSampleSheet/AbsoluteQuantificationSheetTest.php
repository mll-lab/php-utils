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
        $coordinateSystem = new CoordinateSystem12x8();

        $samples = Collection::make([
            'A1' => new AbsoluteQuantificationSample('Standard_1', '485-520', 'FF0000', 'Standard', '1000.0', null),
            'B1' => new AbsoluteQuantificationSample('Standard_1', '485-520', 'FF0001', 'Standard', '1000.0', Coordinates::fromString('A1', $coordinateSystem)),
            'C1' => new AbsoluteQuantificationSample('Standard_2', '485-520', '00FF00', 'Standard', '100.0', null),
            'D1' => new AbsoluteQuantificationSample('Standard_2', '485-520', '00FF01', 'Standard', '100.0', Coordinates::fromString('C1', $coordinateSystem)),
            'E1' => new AbsoluteQuantificationSample('Sample_001', '485-520', '0000FF', 'Unknown', '', null),
            'F1' => new AbsoluteQuantificationSample('Sample_001', '485-520', '0000FE', 'Unknown', '', Coordinates::fromString('E1', $coordinateSystem)),
            'G1' => new AbsoluteQuantificationSample('Sample_002', '485-520', 'FFFF00', 'Unknown', '', null),
            'H1' => new AbsoluteQuantificationSample('Sample_002', '485-520', 'FFFF01', 'Unknown', '', Coordinates::fromString('G1', $coordinateSystem)),
            'A2' => new AbsoluteQuantificationSample('NTC', '485-520', '000000', 'Negative Control', '', null),
            'B2' => new AbsoluteQuantificationSample('NTC', '485-520', '000001', 'Negative Control', '', Coordinates::fromString('A2', $coordinateSystem)),
        ]);

        $sheet = new AbsoluteQuantificationSheet();
        $result = $sheet->generate($samples);

        $expected = <<<EOT
"General:Pos"\t"General:Sample Name"\t"General:Repl. Of"\t"General:Filt. Comb."\t"Sample Preferences:Color"\t"Abs Quant:Sample Type"\t"Abs Quant:Concentration"
A1\t"Standard_1"\t""\t485-520\t$00FF0000\t"Standard"\t"1000.0"
B1\t"Standard_1"\t"A1"\t485-520\t$00FF0001\t"Standard"\t"1000.0"
C1\t"Standard_2"\t""\t485-520\t$0000FF00\t"Standard"\t"100.0"
D1\t"Standard_2"\t"C1"\t485-520\t$0000FF01\t"Standard"\t"100.0"
E1\t"Sample_001"\t""\t485-520\t$000000FF\t"Unknown"\t""
F1\t"Sample_001"\t"E1"\t485-520\t$000000FE\t"Unknown"\t""
G1\t"Sample_002"\t""\t485-520\t$00FFFF00\t"Unknown"\t""
H1\t"Sample_002"\t"G1"\t485-520\t$00FFFF01\t"Unknown"\t""
A2\t"NTC"\t""\t485-520\t$00000000\t"Negative Control"\t""
B2\t"NTC"\t"A2"\t485-520\t$00000001\t"Negative Control"\t""

EOT;

        self::assertSame(StringUtil::normalizeLineEndings($expected), $result);
    }
}

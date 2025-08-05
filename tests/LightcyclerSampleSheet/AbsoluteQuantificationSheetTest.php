<?php declare(strict_types=1);

namespace MLL\Utils\Tests\LightcyclerSampleSheet;

use Illuminate\Support\Collection;
use MLL\Utils\LightcyclerSampleSheet\AbsoluteQuantificationSample;
use MLL\Utils\LightcyclerSampleSheet\AbsoluteQuantificationSheet;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class AbsoluteQuantificationSheetTest extends TestCase
{
    public function testGenerateWithFakeData(): void
    {
        $samples = Collection::make([
            'A1' => new AbsoluteQuantificationSample('Standard_1', '485-520', 'FF0000', 'Standard', 'Standard_1_target', 1000),
            'B1' => new AbsoluteQuantificationSample('Standard_1', '485-520', 'FF0001', 'Standard', 'Standard_1_target', 1000),
            'C1' => new AbsoluteQuantificationSample('Standard_2', '485-520', '00FF00', 'Standard', 'Standard_2', 100),
            'D1' => new AbsoluteQuantificationSample('Standard_2', '485-520', '00FF01', 'Standard', 'Standard_2', 100),
            'E1' => new AbsoluteQuantificationSample('Sample_001', '485-520', '0000FF', 'Unknown', 'Sample_001', null),
            'F1' => new AbsoluteQuantificationSample('Sample_001', '485-520', '0000FE', 'Unknown', 'Sample_001', null),
            'G1' => new AbsoluteQuantificationSample('Sample_002', '485-520', 'FFFF00', 'Unknown', 'Sample_002', null),
            'H1' => new AbsoluteQuantificationSample('Sample_002', '485-520', 'FFFF01', 'Unknown', 'Sample_002', null),
            'A2' => new AbsoluteQuantificationSample('NTC', '485-520', '000000', 'Negative Control', 'NTC', null),
            'B2' => new AbsoluteQuantificationSample('NTC', '485-520', '000001', 'Negative Control', 'NTC', null),
            'C2' => new AbsoluteQuantificationSample('Standard_1', '485-520', 'FF0000', 'Standard', 'Standard_1_reference', 1000),
            'D2' => new AbsoluteQuantificationSample('Standard_1', '485-520', 'FF0001', 'Standard', 'Standard_1_reference', 1000),
        ]);

        $sheet = new AbsoluteQuantificationSheet();
        $result = $sheet->generate($samples);

        $expected = <<<EOT
General:Pos\t"General:Sample Name"\t"General:Repl. Of"\t"General:Filt. Comb."\t"Sample Preferences:Color"\t"Abs Quant:Sample Type"\t"Abs Quant:Concentration"
A1\tStandard_1\tA1\t485-520\t$00FF0000\tStandard\t1.00E3
B1\tStandard_1\tA1\t485-520\t$00FF0001\tStandard\t1.00E3
C1\tStandard_2\tC1\t485-520\t$0000FF00\tStandard\t1.00E2
D1\tStandard_2\tC1\t485-520\t$0000FF01\tStandard\t1.00E2
E1\tSample_001\tE1\t485-520\t$000000FF\tUnknown\t
F1\tSample_001\tE1\t485-520\t$000000FE\tUnknown\t
G1\tSample_002\tG1\t485-520\t$00FFFF00\tUnknown\t
H1\tSample_002\tG1\t485-520\t$00FFFF01\tUnknown\t
A2\tNTC\tA2\t485-520\t$00000000\t"Negative Control"\t
B2\tNTC\tA2\t485-520\t$00000001\t"Negative Control"\t
C2\tStandard_1\tC2\t485-520\t$00FF0000\tStandard\t1.00E3
D2\tStandard_1\tC2\t485-520\t$00FF0001\tStandard\t1.00E3

EOT;

        self::assertSame(StringUtil::normalizeLineEndings($expected), $result);
    }
}

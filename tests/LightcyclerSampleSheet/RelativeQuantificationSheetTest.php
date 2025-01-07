<?php declare(strict_types=1);

namespace MLL\Utils\Tests\LightcyclerSampleSheet;

use Illuminate\Support\Collection;
use MLL\Utils\LightcyclerSampleSheet\RelativeQuantificationSample;
use MLL\Utils\LightcyclerSampleSheet\RelativeQuantificationSheet;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class RelativeQuantificationSheetTest extends TestCase
{
    public function testGenerate(): void
    {
        $samples = Collection::make([
            'A1' => new RelativeQuantificationSample('Sample 1', null, '498-640', 'FF378A'),
            'B1' => new RelativeQuantificationSample('Sample 2', null, '498-640', '4899D1'),
            'C1' => new RelativeQuantificationSample('Sample 3', null, '498-640', '8528B9'),
            'D1' => new RelativeQuantificationSample('Sample 4', null, '498-640', '8E05D9'),
            'E1' => new RelativeQuantificationSample('Sample 5', null, '498-640', '4080A5'),
        ]);

        $sheet = new RelativeQuantificationSheet();
        $result = $sheet->generate($samples);

        $expected = <<<EOT
"General:Pos"\t"General:Sample Name"\t"General:Repl. Of"\t"General:Filt. Comb."\t"Sample Preferences:Color"
A1\t"Sample 1"\t""\t498-640\t$00FF378A
B1\t"Sample 2"\t""\t498-640\t$004899D1
C1\t"Sample 3"\t""\t498-640\t$008528B9
D1\t"Sample 4"\t""\t498-640\t$008E05D9
E1\t"Sample 5"\t""\t498-640\t$004080A5

EOT;

        self::assertSame(StringUtil::normalizeLineEndings($expected), $result);
    }
}

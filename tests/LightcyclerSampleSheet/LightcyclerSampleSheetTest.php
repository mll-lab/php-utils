<?php declare(strict_types=1);

namespace MLL\Utils\Tests\LightcyclerSampleSheet;

use MLL\Utils\LightcyclerSampleSheet\LightcyclerSampleSheet;
use MLL\Utils\LightcyclerSampleSheet\RandomHexGenerator;
use MLL\Utils\LightcyclerSampleSheet\SampleDTO;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\Microplate;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class LightcyclerSampleSheetTest extends TestCase
{
    public function testGenerate(): void
    {
        $randomHexGeneratorMock = $this->createMock(RandomHexGenerator::class);
        $randomHexGeneratorMock->method('hex6Digits')
            ->willReturnOnConsecutiveCalls(
                'FF378A',
                '4899D1',
                '8528B9',
                '8E05D9',
                '4080A5'
        );

        $samples = [
            'A1' => new SampleDTO('Sample 1', 'Type 1', 'Target 1'),
            'B1' => new SampleDTO('Sample 2', 'Type 2', 'Target 2'),
            'C1' => new SampleDTO('Sample 3', 'Type 3', 'Target 3'),
            'D1' => new SampleDTO('Sample 4', 'Type 4', 'Target 4'),
            'E1' => new SampleDTO('Sample 5', 'Type 5', 'Target 5')
        ];

        $microplate = new Microplate(new CoordinateSystem12x8());
        foreach ($samples as $coordinateFromKey => $sample) {
            $microplate->addWell(
                Coordinates::fromString($coordinateFromKey, $microplate->coordinateSystem),
                $sample
            );
        }

        $lightcyclerSampleSheet = new LightcyclerSampleSheet();
        $result = $lightcyclerSampleSheet->generate($microplate, $randomHexGeneratorMock);

        $expected = <<<EOT
General:Pos\t"General:Sample Name"\t"General:Repl. Of"\t"General:Filt. Comb."\t"Sample Preferences:Color"
A1\t"Sample 1"\t""\t498-640\t$00FF378A
B1\t"Sample 2"\t""\t498-640\t$004899D1
C1\t"Sample 3"\t""\t498-640\t$008528B9
D1\t"Sample 4"\t""\t498-640\t$008E05D9
E1\t"Sample 5"\t""\t498-640\t$004080A5
EOT;

        self::assertSame(StringUtil::normalizeLineEndings($expected), $result);
    }
}

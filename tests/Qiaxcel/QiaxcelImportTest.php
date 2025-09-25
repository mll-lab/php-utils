<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Qiaxcel;

use MLL\Utils\Qiaxcel\QiaxcelImport;
use PHPUnit\Framework\TestCase;

final class QiaxcelImportTest extends TestCase
{
    public function testGenerate(): void
    {
        $newQiaxelImport = new QiaxcelImport(
            'test.xlsx',
        );

        foreach (range(1, 13) as $i) {
            $newQiaxelImport->addEntry("Test-Eintrag {$i}");
        }

        $spreadsheet = $newQiaxelImport->generate();
        $worksheet = $spreadsheet->getActiveSheet();
        self::assertEquals('Test-Eintrag 1', $worksheet->getCell('A1')->getValue());
        self::assertSame('Test-Eintrag 12', $worksheet->getCell('L1')->getValue());
        self::assertSame('Test-Eintrag 13', $worksheet->getCell('A2')->getValue());
        self::assertSame('Leer', $worksheet->getCell('B2')->getValue());
        self::assertSame('Leer', $worksheet->getCell('L8')->getValue());
    }
}

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
        $cellA1 = $worksheet->getCell('A1');
        self::assertNotNull($cellA1); // @phpstan-ignore staticMethod.alreadyNarrowedType
        self::assertEquals('Test-Eintrag 1', $cellA1->getValue());
        $cellL1 = $worksheet->getCell('L1');
        self::assertNotNull($cellL1); // @phpstan-ignore staticMethod.alreadyNarrowedType
        self::assertSame('Test-Eintrag 12', $cellL1->getValue());
        $cellA2 = $worksheet->getCell('A2');
        self::assertNotNull($cellA2); // @phpstan-ignore staticMethod.alreadyNarrowedType
        self::assertSame('Test-Eintrag 13', $cellA2->getValue());
        $cellB2 = $worksheet->getCell('B2');
        self::assertNotNull($cellB2); // @phpstan-ignore staticMethod.alreadyNarrowedType
        self::assertSame('Leer', $cellB2->getValue());
        $cellL8 = $worksheet->getCell('L8');
        self::assertNotNull($cellL8); // @phpstan-ignore staticMethod.alreadyNarrowedType
        self::assertSame('Leer', $cellL8->getValue());
    }
}

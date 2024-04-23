<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Unit\QxManager;

use Carbon\Carbon;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem96Well;
use MLL\Utils\Microplate\Microplate;
use MLL\Utils\QxManager\FilledRow;
use MLL\Utils\QxManager\FilledWell;
use MLL\Utils\QxManager\QxManagerSampleSheet;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class QxManagerSampleSheetTest extends TestCase
{
    public function testToCsvString(): void
    {
        $famRowMock = $this->createMock(FilledRow::class);
        $famRowMock->expects(self::exactly(2))
            ->method('toString')
            ->willReturn('FAM Row String');

        $hexRowMock = $this->createMock(FilledRow::class);
        $hexRowMock->expects(self::exactly(2))
            ->method('toString')
            ->willReturn('HEX Row String');

        $filledWell = new FilledWell($famRowMock, $hexRowMock);

        /** @var Microplate<FilledWell, CoordinateSystem96Well> $microplate */
        $microplate = new Microplate(new CoordinateSystem96Well());
        $microplate->addWell(
            Coordinates::fromString('F1', new CoordinateSystem96Well()),
            $filledWell
        );

        $microplate->addWell(
            Coordinates::fromString('H12', new CoordinateSystem96Well()),
            $filledWell
        );

        $createdDate = Carbon::now();
        $sampleSheet = new QxManagerSampleSheet();
        $csvString = $sampleSheet->toCsvString($microplate, $createdDate);

        $expectedCsvString = <<<CSV
ddplate - DO NOT MODIFY THIS LINE,Version=1,ApplicationName=QX Manager Standard Edition,ApplicationVersion=2.0.0.665,ApplicationEdition=ResearchEmbedded,User=\QX User,CreatedDate={$createdDate->format('n/j/Y g:i:s A')},

PlateSize=GCR96
PlateNotes=
Well,Perform Droplet Reading,ExperimentType,Sample description 1,Sample description 2,Sample description 3,Sample description 4,SampleType,SupermixName,AssayType,TargetName,TargetType,Signal Ch1,Signal Ch2,Reference Copies,Well Notes,Plot?,RdqConversionFactor
A01,No,,,,,,,,,,,,,,,,
A02,No,,,,,,,,,,,,,,,,
A03,No,,,,,,,,,,,,,,,,
A04,No,,,,,,,,,,,,,,,,
A05,No,,,,,,,,,,,,,,,,
A06,No,,,,,,,,,,,,,,,,
A07,No,,,,,,,,,,,,,,,,
A08,No,,,,,,,,,,,,,,,,
A09,No,,,,,,,,,,,,,,,,
A10,No,,,,,,,,,,,,,,,,
A11,No,,,,,,,,,,,,,,,,
A12,No,,,,,,,,,,,,,,,,
B01,No,,,,,,,,,,,,,,,,
B02,No,,,,,,,,,,,,,,,,
B03,No,,,,,,,,,,,,,,,,
B04,No,,,,,,,,,,,,,,,,
B05,No,,,,,,,,,,,,,,,,
B06,No,,,,,,,,,,,,,,,,
B07,No,,,,,,,,,,,,,,,,
B08,No,,,,,,,,,,,,,,,,
B09,No,,,,,,,,,,,,,,,,
B10,No,,,,,,,,,,,,,,,,
B11,No,,,,,,,,,,,,,,,,
B12,No,,,,,,,,,,,,,,,,
C01,No,,,,,,,,,,,,,,,,
C02,No,,,,,,,,,,,,,,,,
C03,No,,,,,,,,,,,,,,,,
C04,No,,,,,,,,,,,,,,,,
C05,No,,,,,,,,,,,,,,,,
C06,No,,,,,,,,,,,,,,,,
C07,No,,,,,,,,,,,,,,,,
C08,No,,,,,,,,,,,,,,,,
C09,No,,,,,,,,,,,,,,,,
C10,No,,,,,,,,,,,,,,,,
C11,No,,,,,,,,,,,,,,,,
C12,No,,,,,,,,,,,,,,,,
D01,No,,,,,,,,,,,,,,,,
D02,No,,,,,,,,,,,,,,,,
D03,No,,,,,,,,,,,,,,,,
D04,No,,,,,,,,,,,,,,,,
D05,No,,,,,,,,,,,,,,,,
D06,No,,,,,,,,,,,,,,,,
D07,No,,,,,,,,,,,,,,,,
D08,No,,,,,,,,,,,,,,,,
D09,No,,,,,,,,,,,,,,,,
D10,No,,,,,,,,,,,,,,,,
D11,No,,,,,,,,,,,,,,,,
D12,No,,,,,,,,,,,,,,,,
E01,No,,,,,,,,,,,,,,,,
E02,No,,,,,,,,,,,,,,,,
E03,No,,,,,,,,,,,,,,,,
E04,No,,,,,,,,,,,,,,,,
E05,No,,,,,,,,,,,,,,,,
E06,No,,,,,,,,,,,,,,,,
E07,No,,,,,,,,,,,,,,,,
E08,No,,,,,,,,,,,,,,,,
E09,No,,,,,,,,,,,,,,,,
E10,No,,,,,,,,,,,,,,,,
E11,No,,,,,,,,,,,,,,,,
E12,No,,,,,,,,,,,,,,,,
F01,FAM Row String
F01,HEX Row String
F02,No,,,,,,,,,,,,,,,,
F03,No,,,,,,,,,,,,,,,,
F04,No,,,,,,,,,,,,,,,,
F05,No,,,,,,,,,,,,,,,,
F06,No,,,,,,,,,,,,,,,,
F07,No,,,,,,,,,,,,,,,,
F08,No,,,,,,,,,,,,,,,,
F09,No,,,,,,,,,,,,,,,,
F10,No,,,,,,,,,,,,,,,,
F11,No,,,,,,,,,,,,,,,,
F12,No,,,,,,,,,,,,,,,,
G01,No,,,,,,,,,,,,,,,,
G02,No,,,,,,,,,,,,,,,,
G03,No,,,,,,,,,,,,,,,,
G04,No,,,,,,,,,,,,,,,,
G05,No,,,,,,,,,,,,,,,,
G06,No,,,,,,,,,,,,,,,,
G07,No,,,,,,,,,,,,,,,,
G08,No,,,,,,,,,,,,,,,,
G09,No,,,,,,,,,,,,,,,,
G10,No,,,,,,,,,,,,,,,,
G11,No,,,,,,,,,,,,,,,,
G12,No,,,,,,,,,,,,,,,,
H01,No,,,,,,,,,,,,,,,,
H02,No,,,,,,,,,,,,,,,,
H03,No,,,,,,,,,,,,,,,,
H04,No,,,,,,,,,,,,,,,,
H05,No,,,,,,,,,,,,,,,,
H06,No,,,,,,,,,,,,,,,,
H07,No,,,,,,,,,,,,,,,,
H08,No,,,,,,,,,,,,,,,,
H09,No,,,,,,,,,,,,,,,,
H10,No,,,,,,,,,,,,,,,,
H11,No,,,,,,,,,,,,,,,,
H12,FAM Row String
H12,HEX Row String

CSV;

        self::assertSame(StringUtil::normalizeLineEndings($expectedCsvString), $csvString);
    }
}

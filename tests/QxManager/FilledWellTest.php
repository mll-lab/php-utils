<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Unit\QxManager;

use Mll\Microplate\Coordinates;
use Mll\Microplate\CoordinateSystem96Well;
use MLL\Utils\QxManager\FilledRow;
use MLL\Utils\QxManager\FilledWell;
use PHPUnit\Framework\TestCase;

class FilledWellTest extends TestCase
{
    public function testToString(): void
    {
        $coordinates = Coordinates::fromString('C9', new CoordinateSystem96Well());

        $famRowMock = $this->createMock(FilledRow::class);
        $famRowMock->expects(self::once())
            ->method('toString')
            ->willReturn('FAM Row String');

        $hexRowMock = $this->createMock(FilledRow::class);
        $hexRowMock->expects(self::once())
            ->method('toString')
            ->willReturn('HEX Row String');

        $filledWell = new FilledWell($famRowMock, $hexRowMock);

        self::assertEquals("C09,FAM Row String\r\nC09,HEX Row String", $filledWell->toString($coordinates));
    }
}

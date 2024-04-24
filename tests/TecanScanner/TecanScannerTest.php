<?php declare(strict_types=1);

namespace MLL\Utils\Tests\TecanScanner;

use MLL\Utils\Microplate\Exceptions\WellNotEmptyException;
use MLL\Utils\TecanScanner\NoRackIDException;
use MLL\Utils\TecanScanner\TecanScanEmptyException;
use MLL\Utils\TecanScanner\TecanScanner;
use MLL\Utils\TecanScanner\WrongNumberOfWells;
use PHPUnit\Framework\TestCase;

final class TecanScannerTest extends TestCase
{
    public function testCreateFromStringEmpty(): void
    {
        $rawContent = '';
        self::assertFalse(TecanScanner::isValidRawContent($rawContent));

        $this->expectExceptionObject(new TecanScanEmptyException());
        TecanScanner::parseRawContent($rawContent);
    }

    public function testCreateFromUnexpectedLineCount(): void
    {
        $rawContent = "rackid,SA00411242\nA1,FD13945423\nB1,FD32807353";
        self::assertFalse(TecanScanner::isValidRawContent($rawContent));

        $this->expectExceptionObject(new WrongNumberOfWells(96, 2));
        TecanScanner::parseRawContent($rawContent);
    }

    public function testMicroplateHandlesDuplicateCoordinates(): void
    {
        $rawContent = "rackid,SA00411242\nA1,FD13945423\nA1,FD32807353\nC1,NO READ\nD1,NO READ\nE1,NO READ\nF1,NO READ\nG1,NO READ\nH1,NO READ\nA2,NO READ\nB2,NO READ\nC2,NO READ\nD2,NO READ\nE2,NO READ\nF2,NO READ\nG2,NO READ\nH2,NO READ\nA3,NO READ\nB3,NO READ\nC3,NO READ\nD3,NO READ\nE3,NO READ\nF3,NO READ\nG3,NO READ\nH3,NO READ\nA4,NO READ\nB4,NO READ\nC4,NO READ\nD4,NO READ\nE4,NO READ\nF4,NO READ\nG4,NO READ\nH4,NO READ\nA5,NO READ\nB5,NO READ\nC5,NO READ\nD5,NO READ\nE5,NO READ\nF5,NO READ\nG5,NO READ\nH5,NO READ\nA6,NO READ\nB6,NO READ\nC6,NO READ\nD6,NO READ\nE6,NO READ\nF6,NO READ\nG6,NO READ\nH6,NO READ\nA7,NO READ\nB7,NO READ\nC7,NO READ\nD7,NO READ\nE7,NO READ\nF7,NO READ\nG7,NO READ\nH7,NO READ\nA8,NO READ\nB8,NO READ\nC8,NO READ\nD8,NO READ\nE8,NO READ\nF8,NO READ\nG8,NO READ\nH8,NO READ\nA9,NO READ\nB9,NO READ\nC9,NO READ\nD9,NO READ\nE9,NO READ\nF9,NO READ\nG9,NO READ\nH9,NO READ\nA10,NO READ\nB10,NO READ\nC10,NO READ\nD10,NO READ\nE10,NO READ\nF10,NO READ\nG10,NO READ\nH10,NO READ\nA11,NO READ\nB11,NO READ\nC11,NO READ\nD11,NO READ\nE11,NO READ\nF11,NO READ\nG11,NO READ\nH11,NO READ\nA12,NO READ\nB12,NO READ\nC12,NO READ\nD12,NO READ\nE12,NO READ\nF12,NO READ\nG12,NO READ\nH12,NO READ";
        self::assertTrue(TecanScanner::isValidRawContent($rawContent));

        $this->expectExceptionObject(new WellNotEmptyException('Well with coordinates "A1" is not empty. Use setWell() to overwrite the coordinate. Well content "s:10:"FD32807353";" was not added.'));
        TecanScanner::parseRawContent($rawContent);
    }

    public function testNoBarcode(): void
    {
        $rawContent = "A1,FD13945423\nB1,FD32807353\nC1,NO READ\nD1,NO READ\nE1,NO READ\nF1,NO READ\nG1,NO READ\nH1,NO READ\nA2,NO READ\nB2,NO READ\nC2,NO READ\nD2,NO READ\nE2,NO READ\nF2,NO READ\nG2,NO READ\nH2,NO READ\nA3,NO READ\nB3,NO READ\nC3,NO READ\nD3,NO READ\nE3,NO READ\nF3,NO READ\nG3,NO READ\nH3,NO READ\nA4,NO READ\nB4,NO READ\nC4,NO READ\nD4,NO READ\nE4,NO READ\nF4,NO READ\nG4,NO READ\nH4,NO READ\nA5,NO READ\nB5,NO READ\nC5,NO READ\nD5,NO READ\nE5,NO READ\nF5,NO READ\nG5,NO READ\nH5,NO READ\nA6,NO READ\nB6,NO READ\nC6,NO READ\nD6,NO READ\nE6,NO READ\nF6,NO READ\nG6,NO READ\nH6,NO READ\nA7,NO READ\nB7,NO READ\nC7,NO READ\nD7,NO READ\nE7,NO READ\nF7,NO READ\nG7,NO READ\nH7,NO READ\nA8,NO READ\nB8,NO READ\nC8,NO READ\nD8,NO READ\nE8,NO READ\nF8,NO READ\nG8,NO READ\nH8,NO READ\nA9,NO READ\nB9,NO READ\nC9,NO READ\nD9,NO READ\nE9,NO READ\nF9,NO READ\nG9,NO READ\nH9,NO READ\nA10,NO READ\nB10,NO READ\nC10,NO READ\nD10,NO READ\nE10,NO READ\nF10,NO READ\nG10,NO READ\nH10,NO READ\nA11,NO READ\nB11,NO READ\nC11,NO READ\nD11,NO READ\nE11,NO READ\nF11,NO READ\nG11,NO READ\nH11,NO READ\nA12,NO READ\nB12,NO READ\nC12,NO READ\nD12,NO READ\nE12,NO READ\nF12,NO READ\nG12,NO READ\nH12,NO READ";
        self::assertFalse(TecanScanner::isValidRawContent($rawContent));

        $this->expectExceptionObject(new NoRackIDException());
        TecanScanner::parseRawContent($rawContent);
    }

    public function testSuccess(): void
    {
        $rawContent = "rackid,SA00411242\nA1,FD13945423\nB1,FD32807353\nC1,NO READ\nD1,NO READ\nE1,NO READ\nF1,NO READ\nG1,NO READ\nH1,NO READ\nA2,NO READ\nB2,NO READ\nC2,NO READ\nD2,NO READ\nE2,NO READ\nF2,NO READ\nG2,NO READ\nH2,NO READ\nA3,NO READ\nB3,NO READ\nC3,NO READ\nD3,NO READ\nE3,NO READ\nF3,NO READ\nG3,NO READ\nH3,NO READ\nA4,NO READ\nB4,NO READ\nC4,NO READ\nD4,NO READ\nE4,NO READ\nF4,NO READ\nG4,NO READ\nH4,NO READ\nA5,NO READ\nB5,NO READ\nC5,NO READ\nD5,NO READ\nE5,NO READ\nF5,NO READ\nG5,NO READ\nH5,NO READ\nA6,NO READ\nB6,NO READ\nC6,NO READ\nD6,NO READ\nE6,NO READ\nF6,NO READ\nG6,NO READ\nH6,NO READ\nA7,NO READ\nB7,NO READ\nC7,NO READ\nD7,NO READ\nE7,NO READ\nF7,NO READ\nG7,NO READ\nH7,NO READ\nA8,NO READ\nB8,NO READ\nC8,NO READ\nD8,NO READ\nE8,NO READ\nF8,NO READ\nG8,NO READ\nH8,NO READ\nA9,NO READ\nB9,NO READ\nC9,NO READ\nD9,NO READ\nE9,NO READ\nF9,NO READ\nG9,NO READ\nH9,NO READ\nA10,NO READ\nB10,NO READ\nC10,NO READ\nD10,NO READ\nE10,NO READ\nF10,NO READ\nG10,NO READ\nH10,NO READ\nA11,NO READ\nB11,NO READ\nC11,NO READ\nD11,NO READ\nE11,NO READ\nF11,NO READ\nG11,NO READ\nH11,NO READ\nA12,NO READ\nB12,NO READ\nC12,NO READ\nD12,NO READ\nE12,NO READ\nF12,NO READ\nG12,NO READ\nH12,NO READ";

        $fluidXPlate = TecanScanner::parseRawContent($rawContent);
        self::assertCount(96, $fluidXPlate->wells());
        self::assertCount(94, $fluidXPlate->freeWells());
        self::assertSame('SA00411242', $fluidXPlate->rackID);

        self::assertSame([
            'A1' => 'FD13945423',
            'B1' => 'FD32807353',
        ], $fluidXPlate->filledWells()->toArray());
        self::assertTrue(TecanScanner::isValidRawContent($rawContent));
    }

    public function testSuccessForWindowsNewLine(): void
    {
        $rawContent = "rackid,SA00411242\r\nA1,FD13945423\r\nB1,FD32807353\r\nC1,NO READ\r\nD1,NO READ\r\nE1,NO READ\r\nF1,NO READ\r\nG1,NO READ\r\nH1,NO READ\r\nA2,NO READ\r\nB2,NO READ\r\nC2,NO READ\r\nD2,NO READ\r\nE2,NO READ\r\nF2,NO READ\r\nG2,NO READ\r\nH2,NO READ\r\nA3,NO READ\r\nB3,NO READ\r\nC3,NO READ\r\nD3,NO READ\r\nE3,NO READ\r\nF3,NO READ\r\nG3,NO READ\r\nH3,NO READ\r\nA4,NO READ\r\nB4,NO READ\r\nC4,NO READ\r\nD4,NO READ\r\nE4,NO READ\r\nF4,NO READ\r\nG4,NO READ\r\nH4,NO READ\r\nA5,NO READ\r\nB5,NO READ\r\nC5,NO READ\r\nD5,NO READ\r\nE5,NO READ\r\nF5,NO READ\r\nG5,NO READ\r\nH5,NO READ\r\nA6,NO READ\r\nB6,NO READ\r\nC6,NO READ\r\nD6,NO READ\r\nE6,NO READ\r\nF6,NO READ\r\nG6,NO READ\r\nH6,NO READ\r\nA7,NO READ\r\nB7,NO READ\r\nC7,NO READ\r\nD7,NO READ\r\nE7,NO READ\r\nF7,NO READ\r\nG7,NO READ\r\nH7,NO READ\r\nA8,NO READ\r\nB8,NO READ\r\nC8,NO READ\r\nD8,NO READ\r\nE8,NO READ\r\nF8,NO READ\r\nG8,NO READ\r\nH8,NO READ\r\nA9,NO READ\r\nB9,NO READ\r\nC9,NO READ\r\nD9,NO READ\r\nE9,NO READ\r\nF9,NO READ\r\nG9,NO READ\r\nH9,NO READ\r\nA10,NO READ\r\nB10,NO READ\r\nC10,NO READ\r\nD10,NO READ\r\nE10,NO READ\r\nF10,NO READ\r\nG10,NO READ\r\nH10,NO READ\r\nA11,NO READ\r\nB11,NO READ\r\nC11,NO READ\r\nD11,NO READ\r\nE11,NO READ\r\nF11,NO READ\r\nG11,NO READ\r\nH11,NO READ\r\nA12,NO READ\r\nB12,NO READ\r\nC12,NO READ\r\nD12,NO READ\r\nE12,NO READ\r\nF12,NO READ\r\nG12,NO READ\r\nH12,NO READ";

        self::assertTrue(TecanScanner::isValidRawContent($rawContent));
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\FluidXPlate;

use MLL\Utils\FluidXPlate\FluidXPlate;
use MLL\Utils\FluidXPlate\InvalidRackIDException;
use MLL\Utils\FluidXPlate\InvalidTubeBarcodeException;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\Enums\FlowDirection;
use PHPUnit\Framework\TestCase;

final class FluidXPlateTest extends TestCase
{
    public function testCreateFromStringEmpty(): void
    {
        $rackID = '';
        $this->expectExceptionObject(new InvalidRackIDException($rackID));
        new FluidXPlate($rackID);
    }

    public function testCreateWithRandomNameAndReturnsIt(): void
    {
        $rackID = 'testInvalidRackID';
        $this->expectExceptionObject(new InvalidRackIDException($rackID));
        new FluidXPlate($rackID);
    }

    public function testCreatesSuccessfulWithValidBarCode(): void
    {
        $rackID = 'AB12345678';
        $fluidXPlate = new FluidXPlate($rackID);
        self::assertSame($rackID, $fluidXPlate->rackID);
        self::assertCount(96, $fluidXPlate->wells());
        self::assertCount(96, $fluidXPlate->freeWells());
        self::assertCount(0, $fluidXPlate->filledWells());
    }

    public function testCanNotAddInvalidBarcode(): void
    {
        $barcode = 'testWrongBarcode';
        $rackID = 'AB12345678';
        $fluidXPlate = new FluidXPlate($rackID);
        $coordinates = Coordinates::fromString('A1', new CoordinateSystem12x8());

        $this->expectExceptionObject(new InvalidTubeBarcodeException($barcode));
        $fluidXPlate->addWell($coordinates, $barcode);
    }

    public function testCanOnlyAddStringAsBarcode(): void
    {
        $rackID = 'AB12345678';
        $fluidXPlate = new FluidXPlate($rackID);
        $coordinates = Coordinates::fromString('A1', new CoordinateSystem12x8());

        $this->expectException(\TypeError::class);
        // @phpstan-ignore-next-line intentionally wrong
        $fluidXPlate->addWell($coordinates, []);
    }

    public function testCanAddToNextFreeWell(): void
    {
        $rackID = 'AB12345678';
        $fluidXPlate = new FluidXPlate($rackID);
        $expectedCoordinates = Coordinates::fromString('A1', new CoordinateSystem12x8());
        $addToNextFreeWell = $fluidXPlate->addToNextFreeWell('test', FlowDirection::COLUMN());
        self::assertEquals($expectedCoordinates, $addToNextFreeWell);
    }
}

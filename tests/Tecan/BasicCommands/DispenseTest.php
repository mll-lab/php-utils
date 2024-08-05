<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\BasicCommands;

use MLL\Utils\Tecan\BasicCommands\Dispense;
use MLL\Utils\Tecan\LiquidClass\CustomLiquidClass;
use MLL\Utils\Tecan\LiquidClass\MLLLiquidClass;
use MLL\Utils\Tecan\Location\BarcodeLocation;
use MLL\Utils\Tecan\Location\PositionLocation;
use MLL\Utils\Tecan\Rack\FluidXRack;
use MLL\Utils\Tecan\Rack\MLLLabWareRack;
use PHPUnit\Framework\TestCase;

final class DispenseTest extends TestCase
{
    public function testDispenseWithBarcodeLocation(): void
    {
        $barcode = 'barcode';
        $aspirate = new Dispense(100, new BarcodeLocation($barcode, new FluidXRack()), new CustomLiquidClass('TestLiquidClassName'));
        self::assertSame($barcode, $aspirate->location->tubeID());
        self::assertNull($aspirate->location->position());
        self::assertSame('D;;;96FluidX;;barcode;100;TestLiquidClassName;;', $aspirate->toString());
    }

    public function testDispenseWithPositionLocation(): void
    {
        $position = 7;
        $volume = 2.2;
        $aspirate = new Dispense($volume, new PositionLocation($position, MLLLabWareRack::DEST_LC()), MLLLiquidClass::TRANSFER_TEMPLATE());
        self::assertNull($aspirate->location->tubeID());
        self::assertSame((string) $position, $aspirate->location->position());
        self::assertSame("D;DestLC;;96 Well MP LightCycler480;{$position};;{$volume};Transfer_Template;;", $aspirate->toString());
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\BasicCommands;

use MLL\Utils\Tecan\BasicCommands\Dispense;
use MLL\Utils\Tecan\LiquidClass\CustomLiquidClass;
use MLL\Utils\Tecan\LiquidClass\MllLiquidClass;
use MLL\Utils\Tecan\Location\BarcodeLocation;
use MLL\Utils\Tecan\Location\PositionLocation;
use MLL\Utils\Tecan\Rack\CustomRack;
use MLL\Utils\Tecan\Rack\MllLabWareRack;
use PHPUnit\Framework\TestCase;

final class DispenseTest extends TestCase
{
    public function testDispenseWithBarcodeLocation(): void
    {
        $barcode = 'barcode';
        $aspirate = new Dispense(100, new BarcodeLocation($barcode, new CustomRack('TestRackName', 'TestRackType')), new CustomLiquidClass('TestLiquidClassName'));
        self::assertSame($barcode, $aspirate->location->tubeID());
        self::assertNull($aspirate->location->position());
        self::assertSame('D;;;TestRackType;;barcode;100;TestLiquidClassName;;', $aspirate->toString());
    }

    public function testDispenseWithPositionLocation(): void
    {
        $position = 7;
        $volume = 2.2;
        $aspirate = new Dispense($volume, new PositionLocation($position, MllLabWareRack::DEST_LC()), MllLiquidClass::TRANSFER_TEMPLATE());
        self::assertNull($aspirate->location->tubeID());
        self::assertSame((string) $position, $aspirate->location->position());
        self::assertSame("D;DestLC;;96 Well MP LightCycler480;{$position};;{$volume};Transfer_Template;;", $aspirate->toString());
    }
}

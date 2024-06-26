<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\BasicCommands;

use MLL\Utils\Tecan\BasicCommands\Aspirate;
use MLL\Utils\Tecan\LiquidClass\CustomLiquidClass;
use MLL\Utils\Tecan\LiquidClass\MLLLiquidClass;
use MLL\Utils\Tecan\Location\BarcodeLocation;
use MLL\Utils\Tecan\Location\PositionLocation;
use MLL\Utils\Tecan\Rack\CustomRack;
use MLL\Utils\Tecan\Rack\MLLLabWareRack;
use PHPUnit\Framework\TestCase;

final class AspirateTest extends TestCase
{
    public function testAspirateWithBarcodeLocation(): void
    {
        $barcode = 'barcode';
        $aspirate = new Aspirate(100, new BarcodeLocation($barcode, new CustomRack('TestRackName', 'TestRackType')), new CustomLiquidClass('TestLiquidClassName'));
        self::assertSame($barcode, $aspirate->location->tubeID());
        self::assertNull($aspirate->location->position());
        self::assertSame('A;;;TestRackType;;barcode;100;TestLiquidClassName;;', $aspirate->toString());
    }

    public function testAspirateWithPositionLocation(): void
    {
        $position = 7;
        $volume = 2.2;
        $aspirate = new Aspirate($volume, new PositionLocation($position, MLLLabWareRack::DEST_PCR()), MLLLiquidClass::TRANSFER_TEMPLATE());
        self::assertNull($aspirate->location->tubeID());
        self::assertSame((string) $position, $aspirate->location->position());
        self::assertSame('A;DestPCR;;96 Well PCR ABI semi-skirted;' . $position . ';;2.2;Transfer_Template;;', $aspirate->toString());
    }
}

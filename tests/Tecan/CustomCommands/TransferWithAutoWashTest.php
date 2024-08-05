<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\CustomCommands;

use MLL\Utils\StringUtil;
use MLL\Utils\Tecan\CustomCommands\TransferWithAutoWash;
use MLL\Utils\Tecan\LiquidClass\CustomLiquidClass;
use MLL\Utils\Tecan\Location\BarcodeLocation;
use MLL\Utils\Tecan\Rack\MLLLabWareRack;
use PHPUnit\Framework\TestCase;

final class TransferWithAutoWashTest extends TestCase
{
    public function testTransferWithAutoWashCommand(): void
    {
        $liquidClass = new CustomLiquidClass('TestLiquidClassName');
        $rack = MLLLabWareRack::DEST_LC();
        $aspirateLocation = new BarcodeLocation('barcode', $rack);
        $dispenseLocation = new BarcodeLocation('barcode1', $rack);

        $transfer = new TransferWithAutoWash(100, $liquidClass, $aspirateLocation, $dispenseLocation);

        self::assertSame(
            StringUtil::normalizeLineEndings(
                'A;;;96 Well MP LightCycler480;;barcode;100;TestLiquidClassName;;
D;;;96 Well MP LightCycler480;;barcode1;100;TestLiquidClassName;;
W;'
            ),
            $transfer->toString()
        );
    }
}

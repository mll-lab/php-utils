<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\CustomCommands;

use MLL\Utils\StringUtil;
use MLL\Utils\Tecan\CustomCommands\TransferWithAutoWash;
use MLL\Utils\Tecan\LiquidClass\CustomLiquidClass;
use MLL\Utils\Tecan\Location\BarcodeLocation;
use MLL\Utils\Tecan\Rack\FluidXRack;
use PHPUnit\Framework\TestCase;

final class TransferWithAutoWashTest extends TestCase
{
    public function testTransferWithAutoWashCommand(): void
    {
        $liquidClass = new CustomLiquidClass('TestLiquidClassName');
        $rack = new FluidXRack();
        $aspirateLocation = new BarcodeLocation('barcode', $rack);
        $dispenseLocation = new BarcodeLocation('barcode1', $rack);

        $transfer = new TransferWithAutoWash(100, $liquidClass, $aspirateLocation, $dispenseLocation);

        self::assertSame(
            StringUtil::normalizeLineEndings(<<<'CSV'
A;;;96FluidX;;barcode;100;TestLiquidClassName;;
D;;;96FluidX;;barcode1;100;TestLiquidClassName;;
W;
CSV),
            $transfer->toString()
        );
    }
}

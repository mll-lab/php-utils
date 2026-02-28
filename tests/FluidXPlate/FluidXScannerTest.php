<?php declare(strict_types=1);

namespace MLL\Utils\Tests\FluidXPlate;

use MLL\Utils\FluidXPlate\FluidXScanner;
use PHPUnit\Framework\TestCase;

final class FluidXScannerTest extends TestCase
{
    public function testCreateFromStringEmpty(): void
    {
        $fluidXScanner = new FluidXScanner();
        $fluidXPlate = $fluidXScanner->scanPlate(FluidXScanner::LOCALHOST);

        self::assertSame('SA00826894', $fluidXPlate->rackID);
        $filledWells = $fluidXPlate->filledWells();
        self::assertCount(3, $filledWells);
        self::assertSame('FD20024619', $filledWells->get('A1'));
        self::assertSame('FD20024698', $filledWells->get('A2'));
        self::assertSame('FD20024711', $filledWells->get('A3'));
    }
}

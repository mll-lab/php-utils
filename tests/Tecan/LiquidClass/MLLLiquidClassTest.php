<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\LiquidClass;

use MLL\Utils\Tecan\LiquidClass\MLLLiquidClass;
use PHPUnit\Framework\TestCase;

final class MLLLiquidClassTest extends TestCase
{
    public function testNameOfEnum(): void
    {
        self::assertSame('DNA_Dilution', MLLLiquidClass::DNA_DILUTION()->name());
        self::assertSame('DNA_Dilution_Water', MLLLiquidClass::DNA_DILUTION_WATER()->name());
        self::assertSame('Transfer_PCR_Produkt', MLLLiquidClass::TRANSFER_PCR_PRODUKT()->name());
        self::assertSame('Transfer_Mastermix_MP', MLLLiquidClass::TRANSFER_MASTERMIX_MP()->name());
        self::assertSame('Transfer_Template', MLLLiquidClass::TRANSFER_TEMPLATE()->name());
    }
}

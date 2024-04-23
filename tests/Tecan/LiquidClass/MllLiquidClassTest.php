<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\LiquidClass;

use MLL\Utils\Tecan\LiquidClass\MllLiquidClass;
use PHPUnit\Framework\TestCase;

final class MllLiquidClassTest extends TestCase
{
    public function testNameOfEnum(): void
    {
        self::assertSame('DNA_Dilution', MllLiquidClass::DNA_DILUTION()->name());
        self::assertSame('DNA_Dilution_Water', MllLiquidClass::DNA_DILUTION_WATER()->name());
        self::assertSame('Transfer_PCR_Produkt', MllLiquidClass::TRANSFER_PCR_PRODUKT()->name());
        self::assertSame('Transfer_Mastermix_MP', MllLiquidClass::TRANSFER_MASTERMIX_MP()->name());
        self::assertSame('Transfer_Template', MllLiquidClass::TRANSFER_TEMPLATE()->name());
    }
}

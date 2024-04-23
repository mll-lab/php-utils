<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\Rack;

use MLL\Utils\Tecan\Rack\MllLabWareRack;
use PHPUnit\Framework\TestCase;

final class MllLabWareRackTest extends TestCase
{
    public function testNameOfEnum(): void
    {
        self::assertSame('A', MllLabWareRack::A()->name());
        self::assertSame('MPCDNA', MllLabWareRack::MP_CDNA()->name());
        self::assertSame('MPSample', MllLabWareRack::MP_SAMPLE()->name());
        self::assertSame('MPWasser', MllLabWareRack::MP_WATER()->name());
        self::assertSame('FluidX', MllLabWareRack::FLUID_X()->name());
        self::assertSame('MM', MllLabWareRack::MM()->name());
        self::assertSame('DestLC', MllLabWareRack::DEST_LC()->name());
        self::assertSame('DestPCR', MllLabWareRack::DEST_PCR()->name());
        self::assertSame('DestTaqMan', MllLabWareRack::DEST_TAQMAN()->name());
    }

    public function testValueOfEnum(): void
    {
        self::assertSame('Eppis 24x0.5 ml Cooled', MllLabWareRack::A()->type());
        self::assertSame('MP cDNA', MllLabWareRack::MP_CDNA()->type());
        self::assertSame('MP Microplate', MllLabWareRack::MP_SAMPLE()->type());
        self::assertSame('Trough 300ml MCA Portrait', MllLabWareRack::MP_WATER()->type());
        self::assertSame('96FluidX', MllLabWareRack::FLUID_X()->type());
        self::assertSame('Eppis 32x1.5 ml Cooled', MllLabWareRack::MM()->type());
        self::assertSame('96 Well MP LightCycler480', MllLabWareRack::DEST_LC()->type());
        self::assertSame('96 Well PCR ABI semi-skirted', MllLabWareRack::DEST_PCR()->type());
        self::assertSame('96 Well PCR TaqMan', MllLabWareRack::DEST_TAQMAN()->type());
    }
}

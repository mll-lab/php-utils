<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\Rack;

use MLL\Utils\Tecan\Rack\MLLLabWareRack;
use PHPUnit\Framework\TestCase;

final class MLLLabWareRackTest extends TestCase
{
    public function testName(): void
    {
        self::assertSame('A', MLLLabWareRack::A()->name());
        self::assertSame('MPCDNA', MLLLabWareRack::MP_CDNA()->name());
        self::assertSame('MPSample', MLLLabWareRack::MP_SAMPLE()->name());
        self::assertSame('MPWasser', MLLLabWareRack::MP_WATER()->name());
        self::assertSame('FluidX', MLLLabWareRack::FLUID_X()->name());
        self::assertSame('MM', MLLLabWareRack::MM()->name());
        self::assertSame('DestLC', MLLLabWareRack::DEST_LC()->name());
        self::assertSame('DestPCR', MLLLabWareRack::DEST_PCR()->name());
        self::assertSame('DestTaqMan', MLLLabWareRack::DEST_TAQMAN()->name());
    }

    public function testValue(): void
    {
        self::assertSame('Eppis 24x0.5 ml Cooled', MLLLabWareRack::A()->type());
        self::assertSame('MP cDNA', MLLLabWareRack::MP_CDNA()->type());
        self::assertSame('MP Microplate', MLLLabWareRack::MP_SAMPLE()->type());
        self::assertSame('Trough 300ml MCA Portrait', MLLLabWareRack::MP_WATER()->type());
        self::assertSame('96FluidX', MLLLabWareRack::FLUID_X()->type());
        self::assertSame('Eppis 32x1.5 ml Cooled', MLLLabWareRack::MM()->type());
        self::assertSame('96 Well MP LightCycler480', MLLLabWareRack::DEST_LC()->type());
        self::assertSame('96 Well PCR ABI semi-skirted', MLLLabWareRack::DEST_PCR()->type());
        self::assertSame('96 Well PCR TaqMan', MLLLabWareRack::DEST_TAQMAN()->type());
    }
}

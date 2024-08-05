<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\Rack;

use MLL\Utils\Tecan\Rack\AlublockA;
use MLL\Utils\Tecan\Rack\DestLC;
use MLL\Utils\Tecan\Rack\DestPCR;
use MLL\Utils\Tecan\Rack\DestTaqMan;
use MLL\Utils\Tecan\Rack\FluidXRack;
use MLL\Utils\Tecan\Rack\InvalidPositionOnRack;
use MLL\Utils\Tecan\Rack\MasterMixRack;
use MLL\Utils\Tecan\Rack\MPCDNA;
use MLL\Utils\Tecan\Rack\MPSample;
use MLL\Utils\Tecan\Rack\MPWater;
use MLL\Utils\Tecan\Rack\NoEmptyPositionOnRack;
use PHPUnit\Framework\TestCase;

final class RackTest extends TestCase
{
    public function assignsFirstEmptyPosition(): void
    {
        $rack = new MasterMixRack();
        self::assertSame(32, $rack->positionCount());

        $position = $rack->assignFirstEmptyPosition('Sample');
        self::assertEquals(1, $position);
        self::assertEquals('Sample', $rack->positions[1]);
    }

    public function assignsLastEmptyPosition(): void
    {
        $rack = new MasterMixRack();
        $lastPosition = 32;
        self::assertSame($lastPosition, $rack->positionCount());

        $position = $rack->assignLastEmptyPosition('Sample');
        self::assertEquals($lastPosition, $position);
        self::assertEquals('Sample', $rack->positions[$lastPosition]);
    }

    public function throwsExceptionWhenNoEmptyPosition(): void
    {
        $rack = new MPWater();
        $lastPosition = 1;
        self::assertSame($lastPosition, $rack->positionCount());

        $rack->assignFirstEmptyPosition('Sample');

        $this->expectException(NoEmptyPositionOnRack::class);
        $rack->assignFirstEmptyPosition('AnotherSample');
    }

    public function throwsExceptionForInvalidPosition(): void
    {
        $rack = new MasterMixRack();
        $lastPosition = 32;
        self::assertSame($lastPosition, $rack->positionCount());

        $this->expectException(InvalidPositionOnRack::class);
        $rack->assignPosition('Sample', $lastPosition + 1);
    }

    public function testRackA(): void
    {
        $rack = new AlublockA();
        self::assertSame('A', $rack->name());
        self::assertSame('Eppis 24x0.5 ml Cooled', $rack->type());
        self::assertSame(24, $rack->positionCount());
        self::assertCount(24, $rack->positions);
    }

    public function testRackMPCDNA(): void
    {
        $rack = new MPCDNA();
        self::assertSame('MPCDNA', $rack->name());
        self::assertSame('MP cDNA', $rack->type());
        self::assertSame(96, $rack->positionCount());
        self::assertCount(96, $rack->positions);
    }

    public function testRackMPSample(): void
    {
        $rack = new MPSample();
        self::assertSame('MPSample', $rack->name());
        self::assertSame('MP Microplate', $rack->type());
        self::assertSame(96, $rack->positionCount());
        self::assertCount(96, $rack->positions);
    }

    public function testRackMPWasser(): void
    {
        $rack = new MPWater();
        self::assertSame('MPWasser', $rack->name());
        self::assertSame('Trough 300ml MCA Portrait', $rack->type());
        self::assertSame(1, $rack->positionCount());
        self::assertCount(1, $rack->positions);
    }

    public function testRackFluidX(): void
    {
        $rack = new FluidXRack();
        self::assertSame('FluidX', $rack->name());
        self::assertSame('96FluidX', $rack->type());
        self::assertSame(96, $rack->positionCount());
        self::assertCount(96, $rack->positions);
    }

    public function testRackMM(): void
    {
        $rack = new MasterMixRack();
        self::assertSame('MM', $rack->name());
        self::assertSame('Eppis 32x1.5 ml Cooled', $rack->type());
        self::assertSame(32, $rack->positionCount());
        self::assertCount(32, $rack->positions);
    }

    public function testRackDestLC(): void
    {
        $rack = new DestLC();
        self::assertSame('DestLC', $rack->name());
        self::assertSame('96 Well MP LightCycler480', $rack->type());
        self::assertSame(96, $rack->positionCount());
        self::assertCount(96, $rack->positions);
    }

    public function testRackDestPCR(): void
    {
        $rack = new DestPCR();
        self::assertSame('DestPCR', $rack->name());
        self::assertSame('96 Well PCR ABI semi-skirted', $rack->type());
        self::assertSame(96, $rack->positionCount());
        self::assertCount(96, $rack->positions);
    }

    public function testRackDestTaqMan(): void
    {
        $rack = new DestTaqMan();
        self::assertSame('DestTaqMan', $rack->name());
        self::assertSame('96 Well PCR TaqMan', $rack->type());
        self::assertSame(96, $rack->positionCount());
        self::assertCount(96, $rack->positions);
    }
}

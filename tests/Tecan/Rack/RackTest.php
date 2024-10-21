<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\Rack;

use MLL\Utils\Tecan\Rack\AlublockA;
use MLL\Utils\Tecan\Rack\BaseRack;
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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class RackTest extends TestCase
{
    public function testAssignsFirstEmptyPosition(): void
    {
        $rack = new MasterMixRack();
        self::assertSame(32, $rack->positionCount());

        $position = $rack->assignFirstEmptyPosition('Sample');
        self::assertSame(1, $position);
        self::assertSame('Sample', $rack->positions[1]);
    }

    public function testAssignsLastEmptyPosition(): void
    {
        $rack = new MasterMixRack();
        $lastPosition = 32;
        self::assertSame($lastPosition, $rack->positionCount());

        $position = $rack->assignLastEmptyPosition('Sample');
        self::assertSame($lastPosition, $position);
        self::assertSame('Sample', $rack->positions[$lastPosition]);
    }

    public function testThrowsExceptionWhenNoEmptyPosition(): void
    {
        $rack = new MPWater();
        $lastPosition = 1;
        self::assertSame($lastPosition, $rack->positionCount());

        $rack->assignFirstEmptyPosition('Sample');

        $this->expectException(NoEmptyPositionOnRack::class);
        $rack->assignFirstEmptyPosition('AnotherSample');
    }

    public function testThrowsExceptionForInvalidPosition(): void
    {
        $rack = new MasterMixRack();
        $lastPosition = 32;
        self::assertSame($lastPosition, $rack->positionCount());

        $this->expectException(InvalidPositionOnRack::class);
        $rack->assignPosition('Sample', $lastPosition + 1);
    }

    /** @return iterable<array{BaseRack<mixed>, string, string, int}> */
    public static function rackDataProvider(): iterable
    {
        yield 'MPCDNA' => [new MPCDNA(), 'MPCDNA', 'MP cDNA', 96];
        yield 'MPSample' => [new MPSample(), 'MPSample', 'MP Microplate', 96];
        yield 'FluidXRack' => [new FluidXRack(), 'FluidX', '96FluidX', 96];
        yield 'DestLC' => [new DestLC(), 'DestLC', '96 Well MP LightCycler480', 96];
        yield 'DestPCR' => [new DestPCR(), 'DestPCR', '96 Well PCR ABI semi-skirted', 96];
        yield 'DestTaqMan' => [new DestTaqMan(), 'DestTaqMan', '96 Well PCR TaqMan', 96];
        yield 'MasterMixRack' => [new MasterMixRack(), 'MM', 'Eppis 32x1.5 ml Cooled', 32];
        yield 'AlublockA' => [new AlublockA(), 'A', 'Eppis 24x0.5 ml Cooled', 24];
        yield 'MPWater' => [new MPWater(), 'MPWasser', 'Trough 300ml MCA Portrait', 1];
    }

    /**
     * @param BaseRack<mixed> $rack
     *
     * @dataProvider rackDataProvider
     */
    #[DataProvider('rackDataProvider')]
    public function testRackProperties(BaseRack $rack, string $expectedName, string $expectedType, int $expectedPositionCount): void
    {
        self::assertSame($expectedName, $rack->name());
        self::assertSame($expectedType, $rack->type());
        self::assertSame($expectedPositionCount, $rack->positionCount());
        self::assertCount($expectedPositionCount, $rack->positions);
    }
}

<?php declare(strict_types=1);

namespace Tecan\BasicCommands;

use MLL\Utils\Tecan\BasicCommands\AspirateAndDispenseParameters;
use MLL\Utils\Tecan\BasicCommands\ReagentDistribution;
use MLL\Utils\Tecan\LiquidClass\MLLLiquidClass;
use MLL\Utils\Tecan\Rack\MLLLabWareRack;
use MLL\Utils\Tecan\ReagentDistribution\ReagentDistributionDirection;
use PHPUnit\Framework\TestCase;

final class ReagentDistributionTest extends TestCase
{
    public function testFormatToString(): void
    {
        $sourceStartPosition = 13;
        $sourceEndPosition = 13;
        $sourceRack = MLLLabWareRack::MM();
        $source = new AspirateAndDispenseParameters($sourceRack, $sourceStartPosition, $sourceEndPosition);

        $targetStartPosition = 48;
        $targetEndPosition = 73;
        $targetRack = MLLLabWareRack::DEST_PCR();
        $target = new AspirateAndDispenseParameters($targetRack, $targetStartPosition, $targetEndPosition);

        $dispenseVolume = 24;
        $liquidClass = MLLLiquidClass::TRANSFER_MASTERMIX_MP();

        $numberOfDitiReuses = 6;
        $numberOfMultiDisp = 1;
        $direction = ReagentDistributionDirection::LEFT_TO_RIGHT();

        $commandWithoutExcludedWells = new ReagentDistribution(
            $source,
            $target,
            $dispenseVolume,
            $liquidClass,
            $numberOfDitiReuses,
            $numberOfMultiDisp,
            $direction,
        );

        $commandStringWithoutExcludedWells = "R;{$sourceRack->name()};;{$sourceRack->type()};{$sourceStartPosition};{$sourceEndPosition};{$targetRack->name()};;{$targetRack->type()};{$targetStartPosition};{$targetEndPosition};{$dispenseVolume};{$liquidClass->name()};{$numberOfDitiReuses};{$numberOfMultiDisp};{$direction->value};";
        self::assertSame(
            $commandStringWithoutExcludedWells,
            $commandWithoutExcludedWells->toString()
        );

        $excludedWells = [50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71];
        $commandWithExcludedWells = new ReagentDistribution(
            $source,
            $target,
            $dispenseVolume,
            $liquidClass,
            $numberOfDitiReuses,
            $numberOfMultiDisp,
            $direction,
            $excludedWells
        );

        self::assertSame(
            "{$commandStringWithoutExcludedWells}50;51;52;53;54;55;56;57;58;59;60;61;62;63;64;65;66;67;68;69;70;71",
            $commandWithExcludedWells->toString()
        );
    }
}

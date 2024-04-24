<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Tecan\CustomCommands;

use MLL\Utils\Tecan\CustomCommands\AspirateParameters;
use MLL\Utils\Tecan\CustomCommands\DispenseParameters;
use MLL\Utils\Tecan\CustomCommands\MLLReagentDistribution;
use MLL\Utils\Tecan\LiquidClass\MLLLiquidClass;
use MLL\Utils\Tecan\Rack\MLLLabWareRack;
use PHPUnit\Framework\TestCase;

final class MLLReagentDistributionTest extends TestCase
{
    public function testFormatToString(): void
    {
        $sourceStartPosition = 13;
        $sourceRack = MLLLabWareRack::MM();
        $source = new AspirateParameters($sourceRack, $sourceStartPosition);

        $targetRack = MLLLabWareRack::DEST_PCR();
        $target = new DispenseParameters($targetRack, [48, 49, 72, 73]);

        $dispenseVolume = 24;
        $liquidClass = MLLLiquidClass::TRANSFER_MASTERMIX_MP();

        $command = new MLLReagentDistribution(
            $source,
            $target,
            $dispenseVolume,
            $liquidClass,
        );

        $numberOfDitiReuses = MLLReagentDistribution::NUMBER_OF_DITI_REUSES;
        $numberOfMultiDisp = MLLReagentDistribution::NUMBER_OF_MULTI_DISP;

        self::assertSame(
            "R;{$sourceRack->name()};;{$sourceRack->type()};{$sourceStartPosition};{$sourceStartPosition};{$targetRack->name()};;{$targetRack->type()};48;73;{$dispenseVolume};{$liquidClass->name()};{$numberOfDitiReuses};{$numberOfMultiDisp};0;50;51;52;53;54;55;56;57;58;59;60;61;62;63;64;65;66;67;68;69;70;71",
            $command->toString()
        );
    }
}

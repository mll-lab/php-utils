<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\CustomCommands;

use MLL\Utils\Tecan\BasicCommands\Command;
use MLL\Utils\Tecan\BasicCommands\ReagentDistribution;
use MLL\Utils\Tecan\LiquidClass\LiquidClass;
use MLL\Utils\Tecan\ReagentDistribution\ReagentDistributionDirection;

class MLLReagentDistribution extends Command
{
    public const NUMBER_OF_DITI_REUSES = 6;
    public const NUMBER_OF_MULTI_DISP = 1;

    public function __construct(
        private readonly AspirateParameters $source,
        private readonly DispenseParameters $target,
        private readonly float $volume,
        private readonly LiquidClass $liquidClass
    ) {}

    public function toString(): string
    {
        $reagentDistribution = new ReagentDistribution(
            $this->source->formatToAspirateAndDispenseParameters(),
            $this->target->formatToAspirateAndDispenseParameters(),
            $this->volume,
            $this->liquidClass,
            self::NUMBER_OF_DITI_REUSES,
            self::NUMBER_OF_MULTI_DISP,
            ReagentDistributionDirection::LEFT_TO_RIGHT(),
            $this->excludedWells(),
        );

        return $reagentDistribution->toString();
    }

    /** @return array<int> */
    private function excludedWells(): array
    {
        $min = min($this->target->dispensePositions);
        $max = max($this->target->dispensePositions);

        $allWellsFromStartToEnd = range($min, $max);

        return array_diff($allWellsFromStartToEnd, $this->target->dispensePositions);
    }
}

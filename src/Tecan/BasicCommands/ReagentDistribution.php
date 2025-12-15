<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;

use MLL\Utils\Tecan\LiquidClass\LiquidClass;
use MLL\Utils\Tecan\ReagentDistribution\ReagentDistributionDirection;

class ReagentDistribution extends Command
{
    private readonly ReagentDistributionDirection $direction;

    /**
     * @param int|null $numberOfDitiReuses optional maximum number of DiTi reuses allowed (default 1 = no DiTi reuse)
     * @param int|null $numberOfMultiDisp optional maximum number of dispenses in a multidispense sequence (default 1 = no multi-dispense)
     * @param ReagentDistributionDirection|null $direction optional pipetting direction (default = LEFT_TO_RIGHT)
     * @param array<int>|null $excludedTargetWells Optional list of wells in destination labware to be excluded from pipetting
     */
    public function __construct(
        private readonly AspirateAndDispenseParameters $source,
        private readonly AspirateAndDispenseParameters $target,
        private readonly float $volume,
        private readonly LiquidClass $liquidClass,
        private readonly ?int $numberOfDitiReuses = null,
        private readonly ?int $numberOfMultiDisp = null,
        ?ReagentDistributionDirection $direction = null,
        private readonly ?array $excludedTargetWells = null
    ) {
        $this->direction = $direction ?? ReagentDistributionDirection::LEFT_TO_RIGHT();
    }

    public function toString(): string
    {
        return implode(';', [
            'R',
            $this->source->toString(),
            $this->target->toString(),
            $this->volume,
            $this->liquidClass->name(),
            $this->numberOfDitiReuses,
            $this->numberOfMultiDisp,
            $this->direction->value,
            $this->excludedWells(),
        ]);
    }

    private function excludedWells(): string
    {
        if (is_null($this->excludedTargetWells)) {
            return '';
        }

        return implode(';', $this->excludedTargetWells);
    }
}

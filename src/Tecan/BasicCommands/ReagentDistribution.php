<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;

use MLL\Utils\Tecan\LiquidClass\LiquidClass;
use MLL\Utils\Tecan\ReagentDistribution\ReagentDistributionDirection;

final class ReagentDistribution extends Command
{
    private AspirateAndDispenseParameters $source;

    private AspirateAndDispenseParameters $target;

    private float $volume;

    private LiquidClass $liquidClass;

    private ?int $numberOfDitiReuses;

    private ?int $numberOfMultiDisp;

    private ReagentDistributionDirection $direction;

    /** @var array<int, int>|null */
    private ?array $excludedTargetWells;

    /**
     * @param int|null $numberOfDitiReuses optional maximum number of DiTi reuses allowed (default 1 = no DiTi reuse)
     * @param int|null $numberOfMultiDisp optional maximum number of dispenses in a multidispense sequence (default 1 = no multi-dispense)
     * @param ReagentDistributionDirection|null $direction optional pipetting direction (default = LEFT_TO_RIGHT)
     * @param array<int, int>|null $excludedTargetWells Optional list of wells in destination labware to be excluded from pipetting
     */
    public function __construct(
        AspirateAndDispenseParameters $source,
        AspirateAndDispenseParameters $target,
        float $dispenseVolume,
        LiquidClass $liquidClass,
        ?int $numberOfDitiReuses = null,
        ?int $numberOfMultiDisp = null,
        ?ReagentDistributionDirection $direction = null,
        ?array $excludedTargetWells = null
    ) {
        $this->source = $source;
        $this->target = $target;
        $this->volume = $dispenseVolume;
        $this->liquidClass = $liquidClass;
        $this->numberOfDitiReuses = $numberOfDitiReuses;
        $this->numberOfMultiDisp = $numberOfMultiDisp;
        $this->direction = $direction ?? ReagentDistributionDirection::LEFT_TO_RIGHT();
        $this->excludedTargetWells = $excludedTargetWells;
    }

    public function toString(): string
    {
        return implode(
            ';',
            [
                'R',
                $this->source->toString(),
                $this->target->toString(),
                $this->volume,
                $this->liquidClass->name(),
                $this->numberOfDitiReuses,
                $this->numberOfMultiDisp,
                $this->direction->value,
                $this->excludedWells(),
            ]
        );
    }

    private function excludedWells(): string
    {
        if (is_null($this->excludedTargetWells)) {
            return '';
        }

        return implode(';', $this->excludedTargetWells);
    }
}

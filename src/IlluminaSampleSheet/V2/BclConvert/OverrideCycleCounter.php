<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use Illuminate\Support\Collection;

class OverrideCycleCounter
{
    /** @param Collection<int, OverrideCycles> $overrideCyclesList */
    public function __construct(
        public Collection $overrideCyclesList
    ) {}

    public function maxRead1CycleCount(): int
    {
        $max = $this->overrideCyclesList
            ->max(fn (OverrideCycles $overrideCycles): int => $overrideCycles
                ->overrideCycleRead1
                ->sumCountOfAllCycles());
        assert(is_int($max));

        return $max;
    }

    public function maxIndex1CycleCount(): int
    {
        $max = $this->overrideCyclesList
            ->max(fn (OverrideCycles $overrideCycles): int => $overrideCycles
                ->overrideCycleIndex1
                ->sumCountOfAllCycles());
        assert(is_int($max));

        return $max;
    }

    public function maxIndex2CycleCount(): int
    {
        $max = $this->overrideCyclesList
            ->max(
                fn (OverrideCycles $overrideCycles): int => $overrideCycles
                    ->overrideCycleIndex2
                    ?->sumCountOfAllCycles() ?? 0
            );
        assert(is_int($max));

        return $max;
    }

    public function maxRead2CycleCount(): int
    {
        $max = $this->overrideCyclesList
            ->max(
                fn (OverrideCycles $overrideCycles): int => $overrideCycles
                    ->overrideCycleRead2
                    ?->sumCountOfAllCycles() ?? 0
            );
        assert(is_int($max));

        return $max;
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;

class OverrideCycles
{
    /** @var OverrideCycle */
    public $overrideCycleRead1;

    /** @var OverrideCycle */
    public $overrideCycleIndex1;

    /** @var OverrideCycle|null */
    public $overrideCycleIndex2;

    /** @var OverrideCycle|null */
    public $overrideCycleRead2;

    public function __construct(
        OverrideCycle $overrideCycleRead1,
        OverrideCycle $overrideCycleIndex1,
        ?OverrideCycle $overrideCycleIndex2,
        ?OverrideCycle $overrideCycleRead2
    ) {
        $this->overrideCycleRead1 = $overrideCycleRead1;
        $this->overrideCycleIndex1 = $overrideCycleIndex1;
        $this->overrideCycleIndex2 = $overrideCycleIndex2;
        $this->overrideCycleRead2 = $overrideCycleRead2;
    }

    public static function fromString(string $overrideCyclesAsString, IndexOrientation $indexOrientation): self
    {
        $overrideCyclesAsArray = explode(";", $overrideCyclesAsString);
        return new self(
            OverrideCycle::fromString($overrideCyclesAsArray[0], $indexOrientation),
            OverrideCycle::fromString($overrideCyclesAsArray[1], $indexOrientation),
            isset($overrideCyclesAsArray[2])
                ? OverrideCycle::fromString($overrideCyclesAsArray[2], $indexOrientation)
                : null,
            isset($overrideCyclesAsArray[3])
                ? OverrideCycle::fromString($overrideCyclesAsArray[3], $indexOrientation)
                : null
        );
    }

    public function toString(OverrideCycleCounter $overrideCycleCounter): string
    {
        $filledParts = array_filter([ // @phpstan-ignore arrayFilter.strict (we want truthy comparison)
            $this->overrideCycleRead1
                ->fillUpTo($overrideCycleCounter->maxRead1CycleCount())
                ->toString(),
            $this->overrideCycleIndex1
                ->fillUpTo($overrideCycleCounter->maxIndex1CycleCount())
                ->toString(),
            $this->overrideCycleIndex2 !== null
                ? $this->overrideCycleIndex2->fillUpTo($overrideCycleCounter->maxIndex2CycleCount())->toString()
                : null,
            $this->overrideCycleRead2 !== null
                ? $this->overrideCycleRead2->fillUpTo($overrideCycleCounter->maxRead2CycleCount())->toString()
                : null,
        ]);

        return implode(';', $filledParts);
    }
}

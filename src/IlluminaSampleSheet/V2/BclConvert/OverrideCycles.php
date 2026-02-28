<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;

class OverrideCycles
{
    public OverrideCycle $overrideCycleRead1;

    public OverrideCycle $overrideCycleIndex1;

    public ?OverrideCycle $overrideCycleIndex2;

    public ?OverrideCycle $overrideCycleRead2;

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
        $overrideCyclesAsArray = explode(';', $overrideCyclesAsString);

        if (count($overrideCyclesAsArray) < 2) {
            throw new IlluminaSampleSheetException("Invalid OverrideCycles string. Must contain at least 2 semicolon-separated parts (Read1 and Index1): {$overrideCyclesAsString}");
        }

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
                ->fillUpTo($overrideCycleCounter->maxRead1CycleCount(), new NucleotideType(NucleotideType::R1))
                ->toString(),
            $this->overrideCycleIndex1
                ->fillUpTo($overrideCycleCounter->maxIndex1CycleCount(), new NucleotideType(NucleotideType::I1))
                ->toString(),
            $this->overrideCycleIndex2 !== null
                ? $this->overrideCycleIndex2
                    ->fillUpTo($overrideCycleCounter->maxIndex2CycleCount(), new NucleotideType(NucleotideType::I2))
                    ->toString()
                : null,
            $this->overrideCycleRead2 !== null
                ? $this->overrideCycleRead2
                    ->fillUpTo($overrideCycleCounter->maxRead2CycleCount(), new NucleotideType(NucleotideType::R2))
                    ->toString()
                : null,
        ]);

        return implode(';', $filledParts);
    }
}

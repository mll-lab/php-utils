<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;

use MLL\Utils\Tecan\Rack\Rack;

class AspirateAndDispenseParameters
{
    public function __construct(
        private readonly Rack $rack,
        private readonly int $startPosition,
        private readonly int $endPosition
    ) {}

    /** Serializes the aspirate and dispense parameters as part of a reagent distribution according the gwl file format. */
    public function toString(): string
    {
        return implode(';', [
            $this->rack->toString(),
            $this->startPosition,
            $this->endPosition,
        ]);
    }
}

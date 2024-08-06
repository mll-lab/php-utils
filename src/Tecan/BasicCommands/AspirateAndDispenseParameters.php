<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;

use MLL\Utils\Tecan\Rack\Rack;

class AspirateAndDispenseParameters
{
    private Rack $rack;

    private int $startPosition;

    private int $endPosition;

    public function __construct(Rack $rack, int $startPosition, int $endPosition)
    {
        $this->rack = $rack;
        $this->startPosition = $startPosition;
        $this->endPosition = $endPosition;
    }

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

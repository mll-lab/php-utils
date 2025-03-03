<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\CustomCommands;

use MLL\Utils\Tecan\BasicCommands\AspirateAndDispenseParameters;
use MLL\Utils\Tecan\Rack\Rack;

class DispenseParameters
{
    public Rack $rack;

    /** @var non-empty-array<int> */
    public array $dispensePositions;

    /** @param non-empty-array<int> $dispensePositions */
    public function __construct(Rack $rack, array $dispensePositions)
    {
        $this->rack = $rack;
        $this->dispensePositions = $dispensePositions;
    }

    public function formatToAspirateAndDispenseParameters(): AspirateAndDispenseParameters
    {
        // We use min and max of the dispense position as start and end.
        // Exclusion of the not excluded wells will happen in the calling class.
        $startPosition = min($this->dispensePositions);
        $endPosition = max($this->dispensePositions);

        return new AspirateAndDispenseParameters($this->rack, $startPosition, $endPosition);
    }
}

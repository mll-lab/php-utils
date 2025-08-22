<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\CustomCommands;

use MLL\Utils\Tecan\BasicCommands\AspirateAndDispenseParameters;
use MLL\Utils\Tecan\Rack\Rack;

class AspirateParameters
{
    private readonly Rack $rack;

    private readonly int $sourcePosition;

    public function __construct(Rack $rack, int $sourcePosition)
    {
        $this->rack = $rack;
        $this->sourcePosition = $sourcePosition;
    }

    public function formatToAspirateAndDispenseParameters(): AspirateAndDispenseParameters
    {
        // Since the aspiration position is in almost all use-cases a single position
        // and not a range of positions, this class uses only one $sourcePosition
        // as startPosition and endPosition for convenience.
        return new AspirateAndDispenseParameters(
            $this->rack,
            $this->sourcePosition,
            $this->sourcePosition
        );
    }
}

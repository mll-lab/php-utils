<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;

use MLL\Utils\Tecan\LiquidClass\LiquidClass;
use MLL\Utils\Tecan\Location\Location;

class Dispense extends BasicPipettingActionCommand
{
    /**
     * @param float $volume Floating point values are accepted and do not cause an error,
     * but they will be rounded before being used. In such cases, it is recommended to use
     * integer calculations to avoid unexpected results.
     */
    public function __construct(float $volume, Location $location, LiquidClass $liquidClass)
    {
        $this->volume = $volume;
        $this->location = $location;
        $this->liquidClass = $liquidClass;
    }

    public static function commandLetter(): string
    {
        return 'D';
    }
}

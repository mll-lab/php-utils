<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\CustomCommands;

use MLL\Utils\Tecan\BasicCommands\Aspirate;
use MLL\Utils\Tecan\BasicCommands\Command;
use MLL\Utils\Tecan\BasicCommands\Dispense;
use MLL\Utils\Tecan\BasicCommands\UsesTipMask;
use MLL\Utils\Tecan\BasicCommands\Wash;
use MLL\Utils\Tecan\LiquidClass\LiquidClass;
use MLL\Utils\Tecan\Location\Location;
use MLL\Utils\Tecan\TecanProtocol;

class TransferWithAutoWash extends Command implements UsesTipMask
{
    private Aspirate $aspirate;

    private Dispense $dispense;

    public function __construct(float $volume, LiquidClass $liquidClass, Location $aspirateLocation, Location $dispenseLocation)
    {
        $this->aspirate = new Aspirate($volume, $aspirateLocation, $liquidClass);
        $this->dispense = new Dispense($volume, $dispenseLocation, $liquidClass);
    }

    public function toString(): string
    {
        return implode(TecanProtocol::WINDOWS_NEW_LINE, [
            $this->aspirate->toString(),
            $this->dispense->toString(),
            (new Wash())->toString(),
        ]);
    }

    public function setTipMask(int $tipMask): void
    {
        $this->aspirate->setTipMask($tipMask);
        $this->dispense->setTipMask($tipMask);
    }
}

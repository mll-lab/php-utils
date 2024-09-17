<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;
/*
 * The Set DITI Type record can only be used at the very beginning of the worklist or directly after a Break record.
 */
class SetDiTiType extends Command
{
    private int $indexOfDiTi;

    public function __construct(int $indexOfDiTi)
    {
        $this->indexOfDiTi = $indexOfDiTi;
    }

    public function toString(): string
    {
        return "S;{$this->indexOfDiTi}";
    }
}

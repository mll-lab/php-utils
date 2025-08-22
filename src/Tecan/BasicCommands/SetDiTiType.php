<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;

/**
 * Can only be used at the very beginning of the worklist or directly after a Break command.
 *
 * @see BreakCommand
 */
class SetDiTiType extends Command
{
    private readonly int $indexOfDiTi;

    public function __construct(int $indexOfDiTi)
    {
        $this->indexOfDiTi = $indexOfDiTi;
    }

    public function toString(): string
    {
        return "S;{$this->indexOfDiTi}";
    }
}

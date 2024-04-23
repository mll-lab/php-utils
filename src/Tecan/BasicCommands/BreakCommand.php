<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;

class BreakCommand extends Command
{
    public function toString(): string
    {
        return 'B;';
    }
}

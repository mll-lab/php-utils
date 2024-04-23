<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\BasicCommands;

interface UsesTipMask
{
    public function setTipMask(int $tipMask): void;
}

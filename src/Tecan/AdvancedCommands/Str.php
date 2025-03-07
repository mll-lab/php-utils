<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\AdvancedCommands;

class Str
{
    /** @param int|float|string $value */
    public static function encloseWithDoubleQuotes($value): string
    {
        return "\"{$value}\"";
    }
}

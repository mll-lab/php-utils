<?php declare(strict_types=1);

namespace MLL\Utils;

class Number
{
    /**
     * Return number as long as its clamped between min and max.
     *
     * @see https://github.com/matthewbaggett/php-clamp/blob/master/src/Clamp.php
     * @see https://wiki.php.net/rfc/clamp
     *
     * @param float|int $min
     * @param float|int $max
     * @param float|int $current
     */
    public static function clamp($min, $max, $current): float|int
    {
        return max($min, min($max, $current));
    }
}

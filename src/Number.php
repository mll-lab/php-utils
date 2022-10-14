<?php declare(strict_types=1);

namespace MLL\Utils;

final class Number
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
     *
     * @return float|int
     */
    public static function clamp($min, $max, $current)
    {
        return max($min, min($max, $current));
    }
}

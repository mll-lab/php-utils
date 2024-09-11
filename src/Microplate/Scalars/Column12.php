<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\IntRange;

class Column12 extends IntRange
{
    public const MAX_INT = 12;
    public const MIN_INT = 1;

    protected static function max(): int
    {
        return self::MAX_INT;
    }

    protected static function min(): int
    {
        return self::MIN_INT;
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\IntRange;

class Column2 extends IntRange
{
    public const MAX_INT = 2;
    public const MIN_INT = 1;

    public ?string $description = 'Checks if the given column is of the format 2x16-well column';

    protected static function min(): int
    {
        return self::MIN_INT;
    }

    protected static function max(): int
    {
        return self::MAX_INT;
    }
}

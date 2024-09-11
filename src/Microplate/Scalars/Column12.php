<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\IntRange;

class Column12 extends IntRange
{
    public ?string $description = 'Checks if the given column is between 1 and 12';

    protected static function max(): int
    {
        return 12;
    }

    protected static function min(): int
    {
        return 1;
    }
}

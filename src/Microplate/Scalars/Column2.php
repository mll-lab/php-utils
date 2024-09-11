<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\IntRange;

class Column2 extends IntRange
{
    public ?string $description = 'Represents a column in a coordinate system with 2 columns. Allowed values range from 1-2.';

    protected static function min(): int
    {
        return 1;
    }

    protected static function max(): int
    {
        return 2;
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\IntRange;

class Column12 extends IntRange
{
    public ?string $description = 'Represents a column in a coordinate system with 12 columns. Allowed values range from 1-12.';

    protected static function max(): int
    {
        return 12;
    }

    protected static function min(): int
    {
        return 1;
    }
}

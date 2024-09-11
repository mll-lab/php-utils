<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\Regex;

class Row8 extends Regex
{
    public ?string $description = 'Represents a row in a coordinate system with 8 rows. Allowed values range from A-H.';

    public static function regex(): string
    {
        return '/^[A-H]$/';
    }
}

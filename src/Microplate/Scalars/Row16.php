<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\Regex;

class Row16 extends Regex
{
    public ?string $description = 'Represents a row in a coordinate system with 16 rows. Allowed values range from A-P.';

    public static function regex(): string
    {
        return '/^[A-P]$/';
    }
}

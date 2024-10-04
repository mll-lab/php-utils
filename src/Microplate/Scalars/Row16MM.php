<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\Regex;

class Row16MM extends Regex
{
    public ?string $description = 'Represents a row in a coordinate system with 16 rows without the letter J (see AE-347)';

    public static function regex(): string
    {
        return '/^[A-IK-Q]$/';
    }
}

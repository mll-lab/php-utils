<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\Regex;

class Row16 extends Regex
{
    public ?string $description = 'Checks if the given row is of the format A-P-well row';

    public static function regex(): string
    {
        return '/^[A-P]$/';
    }
}

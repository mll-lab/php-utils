<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\Regex;

final class Row96Well extends Regex
{
    public ?string $description = 'Checks if the given row is of the format 96-well row';

    public static function regex(): string
    {
        return '/^[A-H]$/';
    }
}

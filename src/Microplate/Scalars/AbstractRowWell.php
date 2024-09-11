<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use MLL\GraphQLScalars\Regex;

abstract class AbstractRowWell extends Regex
{
    public ?string $description = 'Checks if the given row is of the format 96-well row';

    abstract public static function regex(): string;
}

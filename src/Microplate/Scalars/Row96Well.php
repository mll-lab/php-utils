<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

class Row96Well extends AbstractRowWell
{
    public ?string $description = 'Checks if the given row is of the format 96-well row';

    public static function regex(): string
    {
        return '/^[A-H]$/';
    }
}

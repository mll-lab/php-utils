<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

class Column2x16Well extends AbstractColumnWell
{
    public const MAX_INT = 2;
    public const MIN_INT = 1;

    public ?string $description = 'Checks if the given column is of the format 2x16-well column';

    public function maxInt(): int
    {
        return self::MAX_INT;
    }

    public function minInt(): int
    {
        return self::MIN_INT;
    }
}

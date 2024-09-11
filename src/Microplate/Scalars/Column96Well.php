<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

class Column96Well extends AbstractColumnWell
{
    public const MAX_INT = 12;
    public const MIN_INT = 1;

    public function maxInt(): int
    {
        return self::MAX_INT;
    }

    public function minInt(): int
    {
        return self::MIN_INT;
    }
}

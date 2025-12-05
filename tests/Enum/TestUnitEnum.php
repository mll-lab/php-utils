<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Enum;

use MLL\Utils\Enum\TryFromNameTrait;

enum TestUnitEnum
{
    use TryFromNameTrait;

    case FIRST;
    case SECOND;
    case THIRD;
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\TryFromNameTrait;

enum TestEnum: string
{
    use TryFromNameTrait;

    case FOO = 'foo_value';
    case BAR = 'bar_value';
}

enum PureTestEnum
{
    use TryFromNameTrait;

    case FIRST;
    case SECOND;
    case THIRD;
}

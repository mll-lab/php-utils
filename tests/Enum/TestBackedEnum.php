<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Enum;

use MLL\Utils\Enum\TryFromNameTrait;

enum TestBackedEnum: string
{
    use TryFromNameTrait;

    case FOO = 'foo_value';
    case BAR = 'bar_value';
}

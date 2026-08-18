<?php declare(strict_types=1);

$missingClosureParameter = static function ($factor): int {
    return 2;
};

$missingArrowParameter = static fn ($factor): int => 2;

$typedClosureParameter = static function (int $factor): int {
    return 2 * $factor;
};

$typedArrowParameter = static fn (int $factor): int => 2 * $factor;

$missingMultiLineParameters = static function (
    $first,
    $second
): int {
    return 2;
};

function plainFunctionWithoutParameterType($factor): int
{
    return 2;
}

class MethodWithoutParameterType
{
    public function untyped($factor): int
    {
        return 2;
    }
}

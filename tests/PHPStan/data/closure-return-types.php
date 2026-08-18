<?php declare(strict_types=1);

$missingClosure = static function (int $value) {
    return $value * 2;
};

$missingArrow = static fn (int $value) => $value * 2;

$typedClosure = static function (int $value): int {
    return $value * 2;
};

$typedArrow = static fn (int $value): int => $value * 2;

function plainFunctionWithoutReturnType()
{
    return 1;
}

class MethodWithoutReturnType
{
    public function untyped()
    {
        return 1;
    }
}

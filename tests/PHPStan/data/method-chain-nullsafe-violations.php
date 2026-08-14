<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\data;

class MethodChainNullsafeViolations
{
    public function foo(int $arg = 0): self
    {
        return $this;
    }

    public function bar(int $arg = 0): self
    {
        return $this;
    }

    public function nullSafeChainWithArgs(?self $nullable): void
    {
        $nullable?->foo(1)?->bar(2);
    }

    public function mixedNullSafeChainWithArgs(?self $nullable): void
    {
        $nullable?->foo(1)->bar(2);
    }
}

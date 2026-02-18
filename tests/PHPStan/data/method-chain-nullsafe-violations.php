<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\data;

class MethodChainNullsafeViolations
{
    public function foo(): self
    {
        return $this;
    }

    public function bar(): self
    {
        return $this;
    }

    public function nullSafeChain(?self $nullable): void
    {
        $nullable?->foo()?->bar();
    }

    public function mixedNullSafeAndRegularChain(?self $nullable): void
    {
        $nullable?->foo()->bar();
    }
}

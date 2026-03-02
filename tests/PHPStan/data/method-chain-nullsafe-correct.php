<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\data;

class MethodChainNullsafeCorrect
{
    public function foo(): self
    {
        return $this;
    }

    public function bar(): self
    {
        return $this;
    }

    public function properlySplitNullSafeChain(?self $nullable): void
    {
        $nullable?->foo()
            ?->bar();
    }

    public function noArgNullSafeChain(?self $nullable): void
    {
        $nullable?->foo()?->bar();
    }

    public function mixedNoArgNullSafeChain(?self $nullable): void
    {
        $nullable?->foo()->bar();
    }
}

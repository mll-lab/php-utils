<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\data;

class MethodChainViolations
{
    public function foo(): self
    {
        return $this;
    }

    public function bar(): self
    {
        return $this;
    }

    public function baz(): void {}

    public static function create(): self
    {
        return new self();
    }

    public function twoCallsOnSameLine(): void
    {
        $this->foo()->bar();
    }

    public function threeCallsOnSameLine(): void
    {
        $this->foo()->bar()->baz();
    }

    public function staticPlusTwoMethodCallsOnSameLine(): void
    {
        self::create()->foo()->bar();
    }

    public function arrowFunctionInternalChain(): void
    {
        /** @var list<self> $items */
        $items = [];
        array_map(fn (self $x): self => $x->foo()->bar(), $items);
    }

    public function closureInternalChain(): void
    {
        /** @var list<self> $items */
        $items = [];
        array_map(fn (self $x): int => spl_object_id($x->foo()->bar()), $items);
    }
}

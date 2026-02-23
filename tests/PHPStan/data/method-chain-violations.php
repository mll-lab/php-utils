<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\data;

class MethodChainViolations
{
    public function foo(int $arg = 0): self
    {
        return $this;
    }

    public function bar(int $arg = 0): self
    {
        return $this;
    }

    public function baz(): void {}

    public static function create(): self
    {
        return new self();
    }

    public function twoCallsWithArgs(): void
    {
        $this->foo(1)->bar(2);
    }

    public function threeCallsFirstHasArgs(): void
    {
        $this->foo(1)->bar()->baz();
    }

    public function arrowFunctionChainWithArgs(): void
    {
        /** @var list<self> $items */
        $items = [];
        array_map(fn (self $x): self => $x->foo(1)->bar(2), $items);
    }

    public function closureChainWithArgs(): void
    {
        /** @var list<self> $items */
        $items = [];
        array_map(fn (self $x): int => spl_object_id($x->foo(1)->bar(2)), $items);
    }
}

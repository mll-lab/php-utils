<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\data;

class MethodChainCorrect
{
    public function foo(int $arg = 0): self
    {
        return $this;
    }

    public function bar(): self
    {
        return $this;
    }

    public function baz(): void {}

    public function name(): string
    {
        return 'test';
    }

    public static function create(): self
    {
        return new self();
    }

    /** @var self */
    public object $relation;

    public function singleMethodCall(): void
    {
        $this->foo();
    }

    public function staticPlusSingleMethod(): void
    {
        self::create()->foo();
    }

    public function propertyAccessPlusMethod(): void
    {
        $this->relation->foo();
    }

    public function properlySplitChain(): void
    {
        $this->foo()
            ->bar();
    }

    public function properlySplitThreeChain(): void
    {
        $this->foo()
            ->bar()
            ->baz();
    }

    public function newExpressionPlusSingleMethod(): void
    {
        (new self())->baz();
    }

    public function multilineArgsWithSplitContinuation(): void
    {
        $this->foo(
            1
        )->bar();
    }

    public function chainInsideStringInterpolation(): string
    {
        return "value: {$this->foo()->name()}";
    }

    public function properlySplitChainInClosure(): void
    {
        /** @var list<self> $items */
        $items = [];
        array_map(fn (self $x): self => $x->foo()
            ->bar(), $items);
    }
}

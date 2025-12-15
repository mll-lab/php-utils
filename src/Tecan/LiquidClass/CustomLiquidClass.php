<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\LiquidClass;

class CustomLiquidClass implements LiquidClass
{
    public function __construct(
        private readonly string $name
    ) {}

    public function name(): string
    {
        return $this->name;
    }
}

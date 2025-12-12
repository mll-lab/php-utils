<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\LiquidClass;

class CustomLiquidClass implements LiquidClass
{
    private readonly string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}

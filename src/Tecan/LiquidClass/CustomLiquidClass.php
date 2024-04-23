<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\LiquidClass;

final class CustomLiquidClass implements LiquidClass
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}

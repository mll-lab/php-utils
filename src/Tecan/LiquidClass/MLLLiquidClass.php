<?php declare(strict_types=1);

namespace MLL\Utils\Tecan\LiquidClass;

class MLLLiquidClass implements LiquidClass
{
    public const DNA_DILUTION = 'DNA_Dilution';
    public const DNA_DILUTION_WATER = 'DNA_Dilution_Water';
    public const TRANSFER_PCR_PRODUKT = 'Transfer_PCR_Produkt';
    public const TRANSFER_MASTERMIX_MP = 'Transfer_Mastermix_MP';
    public const TRANSFER_TEMPLATE = 'Transfer_Template'; // DNA-templates and BUFFER!

    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function DNA_DILUTION(): self
    {
        return new self(self::DNA_DILUTION);
    }

    public static function DNA_DILUTION_WATER(): self
    {
        return new self(self::DNA_DILUTION_WATER);
    }

    public static function TRANSFER_PCR_PRODUKT(): self
    {
        return new self(self::TRANSFER_PCR_PRODUKT);
    }

    public static function TRANSFER_MASTERMIX_MP(): self
    {
        return new self(self::TRANSFER_MASTERMIX_MP);
    }

    public static function TRANSFER_TEMPLATE(): self
    {
        return new self(self::TRANSFER_TEMPLATE);
    }

    public function name(): string
    {
        return $this->value;
    }
}

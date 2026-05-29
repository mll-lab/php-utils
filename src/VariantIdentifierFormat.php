<?php declare(strict_types=1);

namespace MLL\Utils;

class VariantIdentifierFormat
{
    public const DASH = 'DASH';
    public const CANONICAL = 'CANONICAL';
    public const TAB = 'TAB';

    public string $value;

    public function __construct(string $value)
    {
        switch ($value) {
            case self::DASH:
            case self::CANONICAL:
            case self::TAB:
                $this->value = $value;
                break;
            default:
                throw new \InvalidArgumentException("Invalid variant identifier format: {$value}.");
        }
    }
}

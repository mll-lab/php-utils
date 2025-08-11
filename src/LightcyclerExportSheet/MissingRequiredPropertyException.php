<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerExportSheet;

final class MissingRequiredPropertyException extends \InvalidArgumentException
{
    public static function forProperty(string $propertyName): self
    {
        return new self("Required property '{$propertyName}' is missing or empty.");
    }
}

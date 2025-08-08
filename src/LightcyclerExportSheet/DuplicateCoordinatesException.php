<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerExportSheet;

final class DuplicateCoordinatesException extends \InvalidArgumentException
{
    /** @param array<string> $duplicateCoordinates */
    public static function forCoordinates(array $duplicateCoordinates): self
    {
        $coordinates = implode(', ', $duplicateCoordinates);

        return new self("Duplicate sample coordinates found: {$coordinates}");
    }
}

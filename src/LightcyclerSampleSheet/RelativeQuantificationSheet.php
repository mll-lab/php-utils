<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use Illuminate\Support\Collection;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class RelativeQuantificationSheet
{
    protected const WINDOWS_NEW_LINE = "\r\n";
    protected const TAB_SEPARATOR = "\t";
    public const HEADER_COLUMNS = [
        '"General:Pos"',
        '"General:Sample Name"',
        '"General:Repl. Of"',
        '"General:Filt. Comb."',
        '"Sample Preferences:Color"',
    ];

    /** @param Collection<string, RelativeQuantificationSample> $samples */
    public function generate(Collection $samples): string
    {
        return $samples
            ->map(function (RelativeQuantificationSample $well, string $coordinateFromKey): array {
                $replicationOf = $well->replicationOf instanceof Coordinates
                    ? "\"{$well->replicationOf->toString()}\""
                    : '""';

                return [
                    Coordinates::fromString($coordinateFromKey, new CoordinateSystem12x8())->toString(),
                    "\"{$well->sampleName}\"",
                    $replicationOf,
                    $well->filterCombination,
                    "$00{$well->hexColor}",
                ];
            })
            ->prepend(self::HEADER_COLUMNS)
            ->map(fn (array $row): string => implode(self::TAB_SEPARATOR, $row))
            ->implode(self::WINDOWS_NEW_LINE)
            . self::WINDOWS_NEW_LINE;
    }
}

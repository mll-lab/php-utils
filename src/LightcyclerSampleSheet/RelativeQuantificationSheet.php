<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use Illuminate\Support\Collection;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class RelativeQuantificationSheet
{
    private const WINDOWS_NEW_LINE = "\r\n";
    private const TAB_SEPARATOR = "\t";
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
        $sampleSheet = implode(self::TAB_SEPARATOR, self::HEADER_COLUMNS) . self::WINDOWS_NEW_LINE;

        foreach ($samples as $coordinateFromKey => $well) {
            $replicationOf = $well->replicationOf instanceof Coordinates ? $well->replicationOf->toString() : '';
            $row = [
                Coordinates::fromString($coordinateFromKey, new CoordinateSystem12x8())->toString(),
                "\"{$well->sampleName}\"",
                "\"{$replicationOf}\"",
                $well->filterCombination,
                "$00{$well->hexColor}",
            ];
            $sampleSheet .= implode(self::TAB_SEPARATOR, $row) . self::WINDOWS_NEW_LINE;
        }

        return $sampleSheet;
    }
}

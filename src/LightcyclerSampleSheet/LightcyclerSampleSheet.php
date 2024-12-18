<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\Microplate;

class LightcyclerSampleSheet
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

    /** @param Microplate<SampleDTO, CoordinateSystem12x8> $microplate */
    public function generate(Microplate $microplate): string
    {
        $sampleSheet = implode(self::TAB_SEPARATOR, self::HEADER_COLUMNS) . self::WINDOWS_NEW_LINE;

        foreach ($microplate->filledWells() as $coordinateFromKey => $well) {
            $replicationOf = $well->replicationOf instanceof Coordinates ? $well->replicationOf->toString() : '';
            $row = [
                Coordinates::fromString($coordinateFromKey, $microplate->coordinateSystem)->toString(),
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

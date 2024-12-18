<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\Microplate;

class LightcyclerSampleSheet
{
    private const WINDOWS_NEW_LINE = "\r\n";
    private const TAB_SEPARATOR = "\t";

    /** @param Microplate<SampleDTO, CoordinateSystem12x8> $microplate */
    public function generate(Microplate $microplate): string
    {
        $sampleSheet = implode(self::TAB_SEPARATOR, [
            '"General:Pos"',
            '"General:Sample Name"',
            '"General:Repl. Of"',
            '"General:Filt. Comb."',
            '"Sample Preferences:Color"',
        ]) . self::WINDOWS_NEW_LINE;

        foreach ($microplate->filledWells() as $coordinateFromKey => $well) {
            $replicationOf = $well->replicationOf instanceof Coordinates ? $well->replicationOf->toString() : '';

            $sampleSheet .= implode(self::TAB_SEPARATOR, [
                Coordinates::fromString($coordinateFromKey, $microplate->coordinateSystem)->toString(),
                "\"{$well->sampleName}\"",
                "\"{$replicationOf}\"",
                $well->filterCombination,
                "$00{$well->hexColor}",
            ]) . self::WINDOWS_NEW_LINE;
        }

        return $sampleSheet;
    }
}

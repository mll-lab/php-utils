<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\Microplate;

class LightcyclerSampleSheet
{
    /** @param Microplate<SampleDTO, CoordinateSystem12x8> $microplate */
    public function generate(Microplate $microplate, RandomHexGenerator $hexGenerator = null): string
    {
        $lc480import = "General:Pos\t\"General:Sample Name\"\t\"General:Repl. Of\"\t\"General:Filt. Comb.\"\t\"Sample Preferences:Color\"\r\n";

        foreach ($microplate->filledWells() as $coordinateFromKey => $well) {
            $row = new LightcyclerRow(
                Coordinates::fromString($coordinateFromKey, $microplate->coordinateSystem),
                $well->sampleName,
                '',
                '498-640',
                $hexGenerator ?? new RandomHexGenerator()
            );

            $lc480import .= $row;
        }

        return $lc480import;
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\QxManager;

use Carbon\CarbonInterface;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;
use MLL\Utils\Microplate\Enums\FlowDirection;
use MLL\Utils\Microplate\Microplate;
use MLL\Utils\StringUtil;

class QxManagerSampleSheet
{
    /** QX Manager runs on Windows. */
    public const NEWLINE = StringUtil::WINDOWS_NEWLINE;

    public const DELIMITER = ',';

    /** @param Microplate<FilledWell, CoordinateSystem12x8> $microplate */
    public function toCsvString(Microplate $microplate, CarbonInterface $createdDate): string
    {
        $header = StringUtil::normalizeLineEndings(<<<CSV
ddplate - DO NOT MODIFY THIS LINE,Version=1,ApplicationName=QX Manager Standard Edition,ApplicationVersion=2.0.0.665,ApplicationEdition=ResearchEmbedded,User=\QX User,CreatedDate={$createdDate->format('n/j/Y g:i:s A')},

PlateSize=GCR96
PlateNotes=
Well,Perform Droplet Reading,ExperimentType,Sample description 1,Sample description 2,Sample description 3,Sample description 4,SampleType,SupermixName,AssayType,TargetName,TargetType,Signal Ch1,Signal Ch2,Reference Copies,Well Notes,Plot?,RdqConversionFactor

CSV);

        $body = $microplate->sortedWells(FlowDirection::ROW())
            ->map(function ($well, string $coordinateString) use ($microplate): string { /** @phpstan-ignore closure.missingParameterType (is in template context) */
                $coordinates = Coordinates::fromString($coordinateString, $microplate->coordinateSystem);

                if ($well instanceof FilledWell) {
                    return $well->toString($coordinates);
                }

                return $coordinates->toPaddedString()
                    . QxManagerSampleSheet::DELIMITER
                    . (new EmptyRow())->toString();
            })
            ->join(self::NEWLINE);

        return $header . $body . self::NEWLINE;
    }
}

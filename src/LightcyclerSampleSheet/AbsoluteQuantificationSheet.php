<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use Illuminate\Support\Collection;
use MLL\Utils\StringUtil;

class AbsoluteQuantificationSheet
{
    public const HEADER_COLUMNS = [
        '"General:Pos"',
        '"General:Sample Name"',
        '"General:Repl. Of"',
        '"General:Filt. Comb."',
        '"Sample Preferences:Color"',
        '"Abs Quant:Sample Type"',
        '"Abs Quant:Concentration"',
    ];

    /** @param Collection<string, AbsoluteQuantificationSample> $samples */
    public function generate(Collection $samples): string
    {
        return $samples
            ->map(fn (AbsoluteQuantificationSample $well, string $coordinateFromKey): array => $well->toSerializableArray($coordinateFromKey))
            ->prepend(self::HEADER_COLUMNS)
            ->map(fn (array $row): string => implode(StringUtil::TAB, $row))
            ->implode(StringUtil::WINDOWS_NEW_LINE)
            . StringUtil::WINDOWS_NEW_LINE;
    }
}

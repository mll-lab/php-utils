<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use Illuminate\Support\Collection;
use MLL\Utils\StringUtil;

class RelativeQuantificationSheet
{
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
            ->map(fn (RelativeQuantificationSample $well, string $coordinateFromKey): array => $well->toSerializableArray($coordinateFromKey))
            ->prepend(self::HEADER_COLUMNS)
            ->map(fn (array $row): string => implode("\t", $row))
            ->implode(StringUtil::WINDOWS_NEWLINE)
            . StringUtil::WINDOWS_NEWLINE;
    }
}

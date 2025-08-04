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
        $replicationMapping = $this->calculateReplicationMapping($samples);

        return $samples
            ->map(fn (AbsoluteQuantificationSample $well, string $coordinateFromKey): array => $well->toSerializableArray(
                $coordinateFromKey,
                $replicationMapping[$coordinateFromKey]
            ))
            ->prepend(self::HEADER_COLUMNS)
            ->map(fn (array $row): string => implode("\t", $row))
            ->implode(StringUtil::WINDOWS_NEWLINE)
            . StringUtil::WINDOWS_NEWLINE;
    }

    /**
     * Calculate replication mapping based on replicationOfKey. Returns a map of coordinate -> replicationOfCoordinate.
     *
     * @param Collection<string, AbsoluteQuantificationSample> $samples
     *
     * @return array<string, string>
     */
    private function calculateReplicationMapping(Collection $samples): array
    {
        $replicationKeyMap = [];
        $mapping = [];

        foreach ($samples as $coordinate => $sample) {
            if (! isset($replicationKeyMap[$sample->replicationOfKey])) {
                // The First occurrence replicates to itself
                $replicationKeyMap[$sample->replicationOfKey] = $coordinate;
                $mapping[$coordinate] = $coordinate;
            } else {
                // Later occurrences replicate to the first occurrence
                $firstOccurrenceCoordinate = $replicationKeyMap[$sample->replicationOfKey];
                $mapping[$coordinate] = $firstOccurrenceCoordinate;
            }
        }

        return $mapping;
    }
}

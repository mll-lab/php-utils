<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use Illuminate\Support\Collection;
use MLL\Utils\CSVArray;

class AbsoluteQuantificationSheet
{
    /** @param Collection<string, AbsoluteQuantificationSample> $samples */
    public function generate(Collection $samples): string
    {
        $replicationMapping = $this->calculateReplicationMapping($samples);

        $data = $samples->map(fn (AbsoluteQuantificationSample $well, string $coordinateFromKey): array => $well->toSerializableArray(
            $coordinateFromKey,
            $replicationMapping[$coordinateFromKey]
        ));

        return CSVArray::toCSV($data, "\t");
    }

    /**
     * Calculate replication mapping based on replicationOfKey.
     *
     * @param Collection<string, AbsoluteQuantificationSample> $samples
     *
     * @return array<string, string> a map of coordinate -> replicationOfCoordinate
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

<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

class InterOpResult
{
    public LaneResult $resultsForRead1;

    public LaneResult $resultsForRead2;

    public RunResult $resultsForRun;

    /**
     * @param array<int, array<string, string>> $summary interop summary rows
     * @param array<string, array<int, array<string, string>>> $reads interop reads keyed by read name
     */
    public function __construct(array $summary, array $reads)
    {
        [$firstDataRead, $lastDataRead] = self::findDataReads($summary);

        $read1Rows = $reads[$firstDataRead] ?? null;
        if ($read1Rows === null || $read1Rows === []) {
            throw new InterOpException("Reads data missing or empty for: {$firstDataRead}.");
        }

        $read2Rows = $reads[$lastDataRead] ?? null;
        if ($read2Rows === null || $read2Rows === []) {
            throw new InterOpException("Reads data missing or empty for: {$lastDataRead}.");
        }

        // First row per read key is the Surface "-" aggregate across all tiles
        $this->resultsForRead1 = LaneResult::fromInterOpRow($read1Rows[0]);
        $this->resultsForRead2 = LaneResult::fromInterOpRow($read2Rows[0]);
        $this->resultsForRun = RunResult::fromLaneResults($this->resultsForRead1, $this->resultsForRead2);
    }

    /**
     * Finds the first and last data (non-index) reads from summary entries.
     *
     * Index reads have "(I)" suffix in their Level field (e.g. "Read 2 (I)").
     * Data reads lack this suffix. The first and last non-index entries are the
     * two data reads, regardless of device type:
     * - MiSeq single-index: Read 1, Read 3
     * - MiSeq dual-index: Read 1, Read 4
     * - i100: Read 3, Read 4
     *
     * @param array<int, array<string, string>> $summary
     *
     * @return array{0: string, 1: string}
     */
    public static function findDataReads(array $summary): array
    {
        $dataReads = [];
        foreach ($summary as $entry) {
            $level = $entry['Level'];
            if ($level === 'Non-indexed' || $level === 'Total') {
                continue;
            }

            if (substr($level, -3) !== '(I)') { // @phpstan-ignore-line theCodingMachineSafe.function (safe from PHP 8.0)
                $dataReads[] = $level;
            }
        }

        $count = count($dataReads);
        if ($count < 2) {
            throw new InterOpException("Expected at least 2 data reads, found {$count}.");
        }

        $lastKey = array_key_last($dataReads);
        assert($lastKey !== null, 'array_key_last() returned null despite count >= 2.');

        return [$dataReads[0], $dataReads[$lastKey]];
    }
}

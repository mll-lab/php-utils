<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;

abstract class DataSection implements Section
{
    /** @var Collection<int, array<int, string|int>> */
    public Collection $rows;

    protected const SAMPLE_ID_INDEX = 0;

    public function __construct()
    {
        $this->rows = new Collection([]);
    }

    /** @return array<string> */
    abstract public function getColumns(): array;

    public function validate(): void
    {
        $hasUniqueSampleIDs = $this->rows
                ->map(fn ($row) => $row[$this::SAMPLE_ID_INDEX])
                ->unique()
                ->count() === $this->rows->count();

        if (! $hasUniqueSampleIDs) {
            throw new IlluminaSampleSheetException('Sample_ID values must be distinct.');
        }
    }

    public function convertSectionToString(): string
    {
        $this->validate();

        $header = implode(',', $this->getColumns());
        $rowsData = $this->rows->map(fn ($row) => implode(',', $row))->implode("\n");

        return "[Data]\n{$header}\n" . $rowsData . "\n";
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;

/** @template TRow of Row */
class DataSection implements Section
{
    /** @var Collection<int, TRow> */
    public Collection $rows;

    public function __construct()
    {
        $this->rows = new Collection([]);
    }

    /** @param TRow $row */
    public function addRow(Row $row): void
    {
        $this->rows->add($row);
    }

    public function validate(): void
    {
        $this->validateDuplicatedSampleIDs();
    }

    public function convertSectionToString(): string
    {
        $this->validate();

        if ($this->rows->first() === null) {
            throw new IlluminaSampleSheetException('Data section must contain at least one row.');
        }
        $header = $this->rows->first()->getColumns()->implode(',');
        $rowsData = $this->rows->map(fn (Row $row) => $row->toString())->implode("\n");

        return "[Data]\n{$header}\n" . $rowsData . "\n";
    }

    protected function validateDuplicatedSampleIDs(): void
    {
        $hasUniqueSampleIDs = $this->rows
                ->map(fn (Row $row) => $row->sampleID)
                ->unique()
                ->count() === $this->rows->count();

        if (! $hasUniqueSampleIDs) {
            throw new IlluminaSampleSheetException('Sample_ID values must be distinct.');
        }
    }
}

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

    /**
     * @param class-string<TRow> $rowClass
     *
     * @phpstan-ignore-next-line As of now, $rowClass is only used to enforce generic type instantiation.
     */
    public function __construct(string $rowClass)
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

        $firstRow = $this->rows->first();
        if ($firstRow === null) {
            throw new IlluminaSampleSheetException('Data section must contain at least one row.');
        }
        $header = $firstRow->getColumns()
            ->implode(',');

        $rowsData = $this->rows
            ->map(fn (Row $row): string => $row->toString())
            ->implode("\n");

        return "[Data]\n{$header}\n{$rowsData}\n";
    }

    protected function validateDuplicatedSampleIDs(): void
    {
        $uniqueSampleIDs = $this->rows
            ->map(fn (Row $row) => $row->sampleID)
            ->unique()
            ->count();
        if ($uniqueSampleIDs !== $this->rows->count()) {
            throw new IlluminaSampleSheetException('Sample_ID values must be distinct.');
        }
    }
}

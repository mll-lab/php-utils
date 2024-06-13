<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;

abstract class DataSection implements Section
{
    /** @var Collection<int, array<int, string|int>> */
    public Collection $rows;

    public function __construct()
    {
        $this->rows = new Collection([]);
    }

    /** @return Collection<int, string> */
    abstract public function getColumns(): Collection;

    public function validate(): void
    {
        $this->validateDuplicatedSampleIDs();
        $this->validateDuplicatedIndices();
    }

    public function convertSectionToString(): string
    {
        $this->validate();

        $header = $this->getColumns()->implode(',');
        $rowsData = $this->rows->map(fn ($row) => implode(',', $row))->implode("\n");

        return "[Data]\n{$header}\n" . $rowsData . "\n";
    }

    protected function validateDuplicatedSampleIDs(): void
    {
        $sampleIdIndex = $this->getColumns()->search('Sample_ID');
        $hasUniqueSampleIDs = $this->rows
                ->map(fn ($row) => $row[$sampleIdIndex])
                ->unique()
                ->count() === $this->rows->count();

        if (! $hasUniqueSampleIDs) {
            throw new IlluminaSampleSheetException('Sample_ID values must be distinct.');
        }
    }

    protected function validateDuplicatedIndices(): void
    {
        // TODO validate indices ?
    }
}

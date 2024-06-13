<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;

abstract class DataSection implements Section
{
    /** @var array<array<string|int>> */
    public array $rows;

    /** @return array<string> */
    abstract public function getColumns(): array;

    public function validate(): void
    {
        $columns = $this->getColumns();

        $columnKey = array_search('Sample_ID', $columns, true);
        assert($columnKey !== false);

        $sampleIDs = array_column($this->rows, $columnKey);
        if (count($sampleIDs) !== count(array_unique($sampleIDs))) {
            throw new IlluminaSampleSheetException('Sample_ID values must be distinct.');
        }
    }

    public function convertSectionToString(): string
    {
        $this->validate();

        $header = implode(',', $this->getColumns());
        $rows = [];
        foreach ($this->rows as $rowData) {
            $rows[] = implode(',', $rowData);
        }

        return "[Data]\n{$header}\n" . implode("\n", $rows) . "\n";
    }
}

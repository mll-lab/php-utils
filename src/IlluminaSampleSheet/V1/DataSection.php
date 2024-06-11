<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\CSVArray;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;

use function Safe\preg_match;

/**
 * @phpstan-import-type CSVPrimitive from CSVArray
 */
class DataSection implements Section
{
    private DataInterface $data;

    public function __construct(DataInterface $data)
    {
        $this->data = $data;
    }

    public function convertSectionToString(): string
    {
        $this->validateData();

        $header = implode(',', $this->data->getColumns());
        $rows = [];
        foreach ($this->data->getRows() as $rowData) {
            $rows[] = implode(',', $rowData);
        }

        return "[Data]\n{$header}\n" . implode("\n", $rows) . "\n";
    }

    private function validateData(): void
    {
        $columns = $this->data->getColumns();
        $rows = $this->data->getRows();

        if (! in_array('Sample_ID', $columns, true)) {
            throw new \InvalidArgumentException('Sample_ID column is required.');
        }

        $columnKey = array_search('Sample_ID', $columns, true);
        assert($columnKey !== false);

        $sampleIDs = array_column($rows, $columnKey);
        if (count($sampleIDs) !== count(array_unique($sampleIDs))) {
            throw new IlluminaSampleSheetException('Sample_ID values must be distinct.');
        }

        // validate Index-Column to be a valid index
        if (in_array('Index', $columns, true)) {
            $indexKey = array_search('Index', $columns, true);
            assert($indexKey !== false);
            $indexes = array_column($rows, $indexKey);
            foreach ($indexes as $index) {
                $this->validateIndex($index);
            }
        }
    }

    /** @param CSVPrimitive $index */
    protected function validateIndex($index): string
    {
        if (! is_string($index)) {
            throw new IlluminaSampleSheetException('Index must be a string.');
        }

        if (! (bool) preg_match('/^[ATCGN]+$/', $index)) {
            throw new IlluminaSampleSheetException("Index '{$index}' contains invalid characters. Only A, T, C, G, N are allowed.");
        }

        return $index;
    }
}

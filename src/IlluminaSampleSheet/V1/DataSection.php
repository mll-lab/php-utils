<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\SectionInterface;
use function Safe\preg_match;

class DataSection implements SectionInterface
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

        $this->uniqueSampleIDs($columns, $rows);
    }

    private function uniqueSampleIDs(array $columns, array $rows): void
    {
        $columnKey = array_search('Sample_ID', $columns, true);
        assert($columnKey !== false);

        $sampleIDs = array_column($rows, $columnKey);
        if (count($sampleIDs) !== count(array_unique($sampleIDs))) {
            throw new \InvalidArgumentException('Sample_ID values must be distinct.');
        }
    }

    protected function validateIndex(string $index): string
    {
        if (! (bool) preg_match('/^[ATCGN]+$/', $index)) {
            throw new IlluminaSampleSheetException('Index contains invalid characters. Only A, T, C, G, N are allowed.');
        }

        return $index;
    }
}

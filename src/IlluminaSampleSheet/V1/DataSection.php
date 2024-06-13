<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\CSVArray;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;

/**
 * @phpstan-import-type CSVPrimitive from CSVArray
 */
class DataSection implements Section
{
    private AbstractSampleSheetData $sampleSheetData;

    public function __construct(AbstractSampleSheetData $sampleSheetData)
    {
        $this->sampleSheetData = $sampleSheetData;
    }

    public function convertSectionToString(): string
    {
        //        $this->data->validate();
        $this->validateData();

        $header = implode(',', $this->sampleSheetData->getColumns());
        $rows = [];
        foreach ($this->sampleSheetData->rows as $rowData) {
            $rows[] = implode(',', $rowData);
        }

        return "[Data]\n{$header}\n" . implode("\n", $rows) . "\n";
    }

    private function validateData(): void
    {
        $columns = $this->sampleSheetData->getColumns();

        $columnKey = array_search('Sample_ID', $columns, true);
        assert($columnKey !== false);

        $sampleIDs = array_column($this->sampleSheetData->rows, $columnKey);
        if (count($sampleIDs) !== count(array_unique($sampleIDs))) {
            throw new IlluminaSampleSheetException('Sample_ID values must be distinct.');
        }
    }
}

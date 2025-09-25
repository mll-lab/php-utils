<?php declare(strict_types=1);

namespace MLL\Utils\Qiaxcel;

use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class QiaxcelImport
{
    public string $fileName;

    public string $valueForEmptyCell = 'Leer';

    /** @var list<string> */
    protected array $entries = [];

    /** @param list<string> $entries */
    public function __construct(
        string $fileName,
        array $entries
    ) {
        $this->fileName = $fileName;
        $this->entries = $entries;
    }

    public function generate(): SpreadSheet
    {
        $sampleSheetData = [];
        foreach (array_chunk($this->entries, 12) as $entryChunks) {
            $sampleSheetRow = [];
            foreach ($entryChunks as $entryChunk) {
                $sampleSheetRow[] = Str::substr($entryChunk, 0, 36); // Maximum 36 characters in Qiaxcel
            }
            $sampleSheetData[] = $sampleSheetRow;
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray($sampleSheetData);
        $this->fillEmptyCells($spreadsheet);

        return $spreadsheet;
    }

    public function generateAndSaveImportFile(): void
    {
        $spreadsheet = $this->generate();
        self::saveSampleSheet($this->fileName, $spreadsheet);
    }

    public static function saveSampleSheet(string $fileName, Spreadsheet $spreadsheet): void
    {
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($fileName);
    }

    private function fillEmptyCells(Spreadsheet &$spreadsheet): void
    {
        foreach (range(1, 8) as $number) {
            foreach (range('A', 'L') as $letter) {
                $cell = $spreadsheet->getActiveSheet()->getCell("{$letter}{$number}");
                if ($cell instanceof Cell) { // @phpstan-ignore instanceof.alwaysTrue
                    $value = $cell->getValue();
                    if ($value === '' || $value === null) {
                        $cell->setValue($this->valueForEmptyCell);
                    }
                }
            }
        }
    }
}

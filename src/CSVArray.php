<?php declare(strict_types=1);

namespace MLL\Utils;

use Exception;
use Illuminate\Support\Arr;

final class CSVArray
{
    /**
     * TODO: fix parsing multiline-content in csv.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function toArray(string $csv, string $delimiter = ';', string $enclosure = '"', string $escape = '\\'): array
    {
        $result = [];

        $lines = StringUtil::splitLines($csv);

        // The first row of the CSV usually contains the column headers
        // We remove it so it does not show up in the result
        $firstLine = array_shift($lines);
        if (is_null($firstLine)) {
            throw new Exception('Missing column headers.');
        }

        /** @var array<int, string> $columnHeaders */
        $columnHeaders = str_getcsv($firstLine, $delimiter, $enclosure, $escape);

        foreach ($lines as $index => $line) {
            if (! StringUtil::hasContent($line)) {
                continue;
            }

            $entries = str_getcsv($line, $delimiter, $enclosure, $escape);
            if (count($entries) !== count($columnHeaders)) {
                throw new Exception("The number of columns in row {$index} does not match the headers in CSV: {$firstLine}");
            }

            foreach ($columnHeaders as $columnIndex => $columnName) {
                $result[$index + 1][$columnName] = $entries[$columnIndex];
            }
        }

        return $result;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     */
    public static function toCSV(array $data, string $delimiter = ';'): string
    {
        if ([] === $data) {
            throw new Exception('Array is empty');
        }

        // Use the keys of the array as the headers of the CSV
        $headerLine = Arr::first($data);
        if (! is_array($headerLine)) {
            throw new Exception('Missing column headers.');
        }

        $content = str_putcsv(
            array_keys($headerLine),
            $delimiter
        )
        . "\r\n";

        foreach ($data as $line) {
            $content .= str_putcsv($line, $delimiter) . "\r\n";
        }

        return $content;
    }
}

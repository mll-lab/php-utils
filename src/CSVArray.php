<?php declare(strict_types=1);

namespace MLL\Utils;

use Illuminate\Support\Arr;

/** @phpstan-type CSVPrimitive bool|float|int|string|\Stringable|null */
class CSVArray
{
    public const DEFAULT_EMPTY_VALUE = '';

    /**
     * TODO: fix parsing multiline-content in csv.
     *
     * @return array<int, array<string, string>>
     */
    public static function toArray(string $csv, string $delimiter = ';', string $enclosure = '"', string $escape = '\\'): array
    {
        /** @var array<int, array<string, string>> $result */
        $result = [];

        $lines = StringUtil::splitLines($csv);

        // The first row of the CSV usually contains the column headers
        // We remove it so it does not show up in the result
        $firstLine = array_shift($lines);
        if (is_null($firstLine)) {
            throw new \Exception('Missing column headers.');
        }

        /** @var array<int, string> $columnHeaders */
        $columnHeaders = str_getcsv($firstLine, $delimiter, $enclosure, $escape);

        foreach ($lines as $index => $line) {
            if (! StringUtil::hasContent($line)) {
                continue;
            }

            /** @var array<int, string> $entries */
            $entries = str_getcsv($line, $delimiter, $enclosure, $escape);
            foreach ($columnHeaders as $columnIndex => $columnName) {
                $result[$index + 1][$columnName] = $entries[$columnIndex] ?? self::DEFAULT_EMPTY_VALUE;
            }
        }

        return $result;
    }

    /** @param array<array<string, CSVPrimitive>> $data */
    public static function toCSV(array $data, string $delimiter = ';', string $lineSeparator = "\r\n"): string
    {
        if ($data === []) {
            throw new \Exception('Array is empty');
        }

        // Use the keys of the array as the headers of the CSV
        $headerItem = Arr::first($data);
        if (! is_array($headerItem)) {
            throw new \Exception('Missing column headers.');
        }
        $headerKeys = array_keys($headerItem);

        $content = str_putcsv($headerKeys, $delimiter) . $lineSeparator;

        foreach ($data as $line) {
            $content .= str_putcsv($line, $delimiter) . $lineSeparator;
        }

        return $content;
    }
}

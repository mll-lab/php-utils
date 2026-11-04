<?php declare(strict_types=1);

namespace MLL\Utils;

use Illuminate\Support\Arr;

/**
 * @phpstan-type CSVPrimitive bool|float|int|string|\Stringable|null
 */
class CSVArray
{
    public const DEFAULT_EMPTY_VALUE = '';

    /** @return array<int, array<string, string>> */
    public static function toArray(string $csv, string $delimiter = ';', string $enclosure = '"', string $escape = '\\'): array
    {
        /** @var array<int, array<string, string>> $result */
        $result = [];

        $records = self::splitRecords($csv, $enclosure, $escape);

        // The first row of the CSV usually contains the column headers
        // We remove it so it does not show up in the result
        $headerRecord = array_shift($records);
        if (is_null($headerRecord)) {
            throw new \Exception('Missing column headers.');
        }

        /** @var array<int, string> $columnHeaders */
        $columnHeaders = str_getcsv($headerRecord, $delimiter, $enclosure, $escape);

        foreach ($records as $index => $record) {
            if (! StringUtil::hasContent($record)) {
                continue;
            }

            /** @var array<int, string> $entries */
            $entries = str_getcsv($record, $delimiter, $enclosure, $escape);
            foreach ($columnHeaders as $columnIndex => $columnName) {
                $result[$index + 1][$columnName] = $entries[$columnIndex] ?? self::DEFAULT_EMPTY_VALUE;
            }
        }

        return $result;
    }

    /** @return array<int, string> */
    private static function splitRecords(string $csv, string $enclosure, string $escape): array
    {
        $records = [];
        $record = '';
        $isInsideEnclosure = false;

        foreach (\Safe\preg_split("/(\r\n|\n|\r)/", $csv, -1, PREG_SPLIT_DELIM_CAPTURE) as $index => $part) {
            assert(is_string($part));

            $isLineBreak = $index % 2 === 1;
            if ($isLineBreak && ! $isInsideEnclosure) {
                $records[] = $record;
                $record = '';

                continue;
            }

            $record .= $part;
            if (! $isLineBreak) {
                $isInsideEnclosure = self::isInsideEnclosureAfter($part, $isInsideEnclosure, $enclosure, $escape);
            }
        }

        $records[] = $record;

        return $records;
    }

    private static function isInsideEnclosureAfter(string $text, bool $isInsideEnclosure, string $enclosure, string $escape): bool
    {
        $length = strlen($text);
        for ($position = 0; $position < $length; ++$position) {
            $character = $text[$position];
            if ($isInsideEnclosure && $character === $escape && $escape !== $enclosure) {
                ++$position;
            } elseif ($character === $enclosure) {
                $isInsideEnclosure = ! $isInsideEnclosure;
            }
        }

        return $isInsideEnclosure;
    }

    /** @param iterable<array<string, CSVPrimitive>> $data */
    public static function toCSV(iterable $data, string $delimiter = ';', string $lineSeparator = StringUtil::WINDOWS_NEWLINE): string
    {
        // Use the keys of the array as the headers of the CSV
        $headerItem = Arr::first($data);
        if ($headerItem === null) {
            throw new \Exception('Expected $data to contain at least one item.');
        }
        assert(
            is_array($headerItem), // @phpstan-ignore function.alreadyNarrowedType (necessary for older PHPStan/Illuminate versions)
            'Expected $data to contain arrays.'
        );
        $headerKeys = array_keys($headerItem);

        $content = str_putcsv($headerKeys, $delimiter) . $lineSeparator;

        foreach ($data as $line) {
            $content .= str_putcsv($line, $delimiter) . $lineSeparator;
        }

        return $content;
    }
}

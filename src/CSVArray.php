<?php declare(strict_types=1);

namespace MLL\Utils;

use Illuminate\Support\Arr;

/**
 * @phpstan-type CSVPrimitive bool|float|int|string|\Stringable|null
 */
class CSVArray
{
    public const DEFAULT_EMPTY_VALUE = '';

    private const FIELD_START = 0;
    private const FIELD_UNENCLOSED = 1;
    private const FIELD_ENCLOSED = 2;
    private const FIELD_AFTER_ENCLOSURE = 3;

    /** @return array<int, array<string, string>> */
    public static function toArray(string $csv, string $delimiter = ';', string $enclosure = '"', string $escape = '\\'): array
    {
        /** @var array<int, array<string, string>> $result */
        $result = [];

        $records = self::splitRecords($csv, $delimiter, $enclosure, $escape);

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

    /**
     * Follows the quoting rules of str_getcsv: an enclosure only opens at the start of a field.
     *
     * @return array<int, string>
     */
    private static function splitRecords(string $csv, string $delimiter, string $enclosure, string $escape): array
    {
        $records = [];
        $recordStart = 0;
        $fieldState = self::FIELD_START;

        $length = strlen($csv);
        for ($position = 0; $position < $length; ++$position) {
            $character = $csv[$position];

            if ($fieldState === self::FIELD_ENCLOSED) {
                if ($character === $escape && $escape !== $enclosure) {
                    ++$position;
                } elseif ($character === $enclosure) {
                    if (($csv[$position + 1] ?? '') === $enclosure) {
                        ++$position;
                    } else {
                        $fieldState = self::FIELD_AFTER_ENCLOSURE;
                    }
                }
            } elseif ($character === "\r" || $character === "\n") {
                $records[] = substr($csv, $recordStart, $position - $recordStart); // @phpstan-ignore-line theCodingMachineSafe.function (safe from PHP 8.0)
                if ($character === "\r" && ($csv[$position + 1] ?? '') === "\n") {
                    ++$position;
                }
                $recordStart = $position + 1;
                $fieldState = self::FIELD_START;
            } elseif ($fieldState === self::FIELD_START && $character === $enclosure) {
                $fieldState = self::FIELD_ENCLOSED;
            } elseif ($character === $delimiter) {
                $fieldState = self::FIELD_START;
            } elseif ($fieldState === self::FIELD_START && strpos(" \t\v\f", $character) === false) {
                $fieldState = self::FIELD_UNENCLOSED;
            }
        }

        $records[] = substr($csv, $recordStart); // @phpstan-ignore-line theCodingMachineSafe.function (safe from PHP 8.0)

        return $records;
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

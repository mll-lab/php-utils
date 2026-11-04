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
        $stream = \Safe\fopen('php://memory', 'r+');
        \Safe\fwrite($stream, $csv);
        \Safe\rewind($stream);

        // The first row of the CSV usually contains the column headers
        // We remove it so it does not show up in the result
        $columnHeaders = fgetcsv($stream, 0, $delimiter, $enclosure, $escape); // @phpstan-ignore-line theCodingMachineSafe.function (Safe\fgetcsv is missing in Safe 1.x)
        if ($columnHeaders === false) {
            \Safe\fclose($stream);

            return [];
        }

        /** @var array<int, array<string, string>> $result */
        $result = [];

        $index = 0;
        while (($entries = fgetcsv($stream, 0, $delimiter, $enclosure, $escape)) !== false) { // @phpstan-ignore-line theCodingMachineSafe.function (Safe\fgetcsv is missing in Safe 1.x)
            ++$index;
            if (count($entries) === 1 && ! StringUtil::hasContent($entries[0])) {
                continue;
            }

            foreach ($columnHeaders as $columnIndex => $columnName) {
                $result[$index][$columnName] = $entries[$columnIndex] ?? self::DEFAULT_EMPTY_VALUE;
            }
        }

        \Safe\fclose($stream);

        return $result;
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

<?php declare(strict_types=1);

namespace MLL\Utils\TapeStation;

use Illuminate\Support\Collection;
use MLL\Utils\CSVArray;
use MLL\Utils\StringUtil;

class CompactRegionTableParser
{
    /**
     * Column name prefixes — used for fuzzy matching because the µ character
     * in "Conc. [ng/µl]" is frequently corrupted during file save/load cycles.
     */
    private const CONCENTRATION_KEY_PREFIX = 'Conc. [ng/';
    private const MOLARITY_KEY = 'Region Molarity [nmol/l]';

    /** @return Collection<int, CompactRegionTableRecord> */
    public static function parse(string $csvContent): Collection
    {
        $csvContent = StringUtil::toUTF8($csvContent);
        $delimiter = self::detectDelimiter($csvContent);

        $rows = CSVArray::toArray($csvContent, $delimiter);

        $records = new Collection();
        foreach ($rows as $row) {
            $records->push(self::recordFromRow($row));
        }

        return $records;
    }

    /** @param array<string, string> $row */
    private static function recordFromRow(array $row): CompactRegionTableRecord
    {
        return new CompactRegionTableRecord(
            fileName: $row['FileName'] ?? '',
            wellID: $row['WellId'] ?? '',
            sampleDescription: $row['Sample Description'] ?? '',
            fromBp: self::parseInt($row, 'From [bp]', 'From [nt]'),
            toBp: self::parseInt($row, 'To [bp]', 'To [nt]'),
            averageSizeBp: self::parseInt($row, 'Average Size [bp]', 'Average Size [nt]'),
            concentrationNgPerUl: self::parseConcentration($row),
            regionMolarityNmolPerL: self::parseFloat($row[self::MOLARITY_KEY] ?? '0'),
            percentOfTotal: self::parseFloat($row['% of Total'] ?? '0'),
            regionComment: $row['Region Comment'] ?? '',
        );
    }

    /**
     * The concentration column header contains µ which may be corrupted.
     * Match by prefix instead of exact key.
     *
     * @param array<string, string> $row
     */
    private static function parseConcentration(array $row): float
    {
        foreach ($row as $key => $value) {
            if (str_starts_with($key, self::CONCENTRATION_KEY_PREFIX)) {
                return self::parseFloat($value);
            }
        }

        throw new \RuntimeException('Concentration column not found. Expected column starting with "' . self::CONCENTRATION_KEY_PREFIX . '"');
    }

    /**
     * Try primary key first, fall back to alternative (bp vs nt).
     *
     * @param array<string, string> $row
     */
    private static function parseInt(array $row, string $primaryKey, string $fallbackKey): int
    {
        $value = $row[$primaryKey] ?? $row[$fallbackKey] ?? null;
        if ($value === null || $value === '') {
            return 0;
        }

        return (int) round(self::parseFloat($value));
    }

    private static function parseFloat(string $value): float
    {
        $trimmed = trim($value);
        if ($trimmed === '' || ! is_numeric($trimmed)) {
            return 0.0;
        }

        return (float) $trimmed;
    }

    private static function detectDelimiter(string $csvContent): string
    {
        $firstLine = strtok($csvContent, "\n");
        if ($firstLine === false) {
            $firstLine = '';
        }

        $semicolonCount = substr_count($firstLine, ';');
        $commaCount = substr_count($firstLine, ',');

        return $semicolonCount > $commaCount ? ';' : ',';
    }
}

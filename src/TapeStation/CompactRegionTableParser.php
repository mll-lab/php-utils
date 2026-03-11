<?php declare(strict_types=1);

namespace MLL\Utils\TapeStation;

use Illuminate\Support\Collection;
use MLL\Utils\CSVArray;
use MLL\Utils\StringUtil;

/**
 * Parses Agilent TapeStation "Compact Region Table" CSV exports.
 *
 * Supports all standard assays (D1000, D5000, RNA, Genomic DNA, Cell-free DNA — all ng/µl + nmol/l).
 * Rejects High Sensitivity assays (pg/µl + pmol/l) — see rejectHighSensitivityAssay().
 */
class CompactRegionTableParser
{
    /** µ in "Conc. [ng/µl]" is frequently corrupted during file save/load cycles. */
    private const CONCENTRATION_KEY_PREFIX = 'Conc. [ng/';
    private const MOLARITY_KEY = 'Region Molarity [nmol/l]';

    /** @return Collection<int, CompactRegionTableRecord> */
    public static function parse(string $csvContent): Collection
    {
        $csvContent = StringUtil::toUTF8($csvContent);
        $delimiter = self::detectDelimiter($csvContent);

        $rows = CSVArray::toArray($csvContent, $delimiter);

        return (new Collection($rows))
            ->map(static fn (array $row): CompactRegionTableRecord => self::recordFromRow($row));
    }

    /** @param array<string, string> $row */
    private static function recordFromRow(array $row): CompactRegionTableRecord
    {
        self::rejectHighSensitivityAssay($row);

        return new CompactRegionTableRecord(
            $row['FileName'] ?? '',
            $row['WellId'] ?? '',
            $row['Sample Description'] ?? '',
            self::parseNullableInt($row, 'From [bp]', 'From [nt]'),
            self::parseInt($row, 'To [bp]', 'To [nt]'),
            self::parseInt($row, 'Average Size [bp]', 'Average Size [nt]'),
            self::parseConcentration($row),
            self::parseFloat($row[self::MOLARITY_KEY] ?? '0'),
            self::parseFloat($row['% of Total'] ?? '0'),
            $row['Region Comment'] ?? ''
        );
    }

    /**
     * HS assays use pg/µl + pmol/l (1000× smaller than ng/µl + nmol/l).
     * Silently parsing those would produce dangerously wrong results.
     *
     * @param array<string, string> $row
     */
    private static function rejectHighSensitivityAssay(array $row): void
    {
        if (array_key_exists('Region Molarity [pmol/l]', $row)) {
            throw new \RuntimeException('High Sensitivity assay detected (pmol/l). This parser only supports standard assays (nmol/l).');
        }

        foreach (array_keys($row) as $key) {
            if (strpos($key, 'Conc. [pg/') === 0) {
                throw new \RuntimeException('High Sensitivity assay detected (pg/µl). This parser only supports standard assays (ng/µl).');
            }
        }
    }

    /** @param array<string, string> $row */
    private static function parseConcentration(array $row): float
    {
        foreach ($row as $key => $value) {
            if (strpos($key, self::CONCENTRATION_KEY_PREFIX) === 0) {
                return self::parseFloat($value);
            }
        }

        throw new \RuntimeException('Concentration column not found. Expected column starting with "' . self::CONCENTRATION_KEY_PREFIX . '"');
    }

    /** @param array<string, string> $row */
    private static function parseNullableInt(array $row, string $primaryKey, string $fallbackKey): ?int
    {
        if (! array_key_exists($primaryKey, $row) && ! array_key_exists($fallbackKey, $row)) {
            return null;
        }

        $value = $row[$primaryKey] ?? $row[$fallbackKey] ?? '';

        return $value === '' ? null : (int) round(self::parseFloat($value));
    }

    /** @param array<string, string> $row */
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

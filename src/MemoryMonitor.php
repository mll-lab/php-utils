<?php declare(strict_types=1);

namespace MLL\Utils;

use function Safe\ini_get;

class MemoryMonitor
{
    private const UNIT_FACTOR = 1024;

    /** @var array<int, string> */
    private const UNITS = ['B', 'KB', 'MB', 'GB', 'TB'];

    public static function usage(): int
    {
        return memory_get_usage();
    }

    public static function peakUsage(): int
    {
        return memory_get_peak_usage();
    }

    public static function availableMemory(): int
    {
        $memoryLimit = ini_get('memory_limit');
        if ($memoryLimit === '-1') {
            return -1;
        }

        return self::convertToBytes($memoryLimit);
    }

    public static function formattedUsage(): string
    {
        $current = self::formatBytes(self::usage());
        $available = self::availableMemory();
        $availableFormatted = $available === -1
            ? 'Unlimited'
            : self::formatBytes($available);

        return "Memory Usage: {$current} / {$availableFormatted}";
    }

    public static function convertToBytes(string $memoryLimit): int
    {
        $unit = strtoupper(substr($memoryLimit, -1));

        switch ($unit) {
            case 'G':
                $factor = self::UNIT_FACTOR ** 3;
                break;
            case 'M':
                $factor = self::UNIT_FACTOR ** 2;
                break;
            case 'K':
                $factor = self::UNIT_FACTOR;
                break;
            default:
                throw new \UnexpectedValueException("Unexpected unit value: {$unit}.");
        }

        return (int) $memoryLimit * $factor;
    }

    public static function formatBytes(int $bytes): string
    {
        $bytes = max($bytes, 0);
        $pow = (int) floor(($bytes > 0 ? log($bytes) : 0) / log(self::UNIT_FACTOR));
        $pow = min($pow, count(self::UNITS) - 1);

        return round($bytes / (self::UNIT_FACTOR ** $pow)) . ' ' . self::UNITS[$pow];
    }
}

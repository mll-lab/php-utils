<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\MemoryMonitor;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MemoryMonitorTest extends TestCase
{
    /** @dataProvider convertToBytesProvider */
    #[DataProvider('convertToBytesProvider')]
    public function testConvertToBytes(int $expected, string $memoryLimit): void
    {
        self::assertSame($expected, MemoryMonitor::convertToBytes($memoryLimit));
    }

    /** @return iterable<array{int, string}> */
    public static function convertToBytesProvider(): iterable
    {
        yield [134217728, '128M'];
        yield [1073741824, '1G'];
        yield [1024, '1K'];
        yield [268435456, '256M'];
        yield [2147483648, '2G'];
    }

    public function testConvertToBytesThrowsOnUnexpectedUnit(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Unexpected unit value: 8.');

        MemoryMonitor::convertToBytes('128');
    }

    /** @dataProvider formatBytesProvider */
    #[DataProvider('formatBytesProvider')]
    public function testFormatBytes(string $expected, int $bytes): void
    {
        self::assertSame($expected, MemoryMonitor::formatBytes($bytes));
    }

    /** @return iterable<array{string, int}> */
    public static function formatBytesProvider(): iterable
    {
        yield ['0 B', 0];
        yield ['1 B', 1];
        yield ['1 KB', 1024];
        yield ['1 MB', 1048576];
        yield ['1 GB', 1073741824];
        yield ['128 MB', 134217728];
        yield ['256 MB', 268435456];
        yield ['2 GB', 2147483648];
    }

    public function testFormatBytesHandlesNegativeValues(): void
    {
        self::assertSame('0 B', MemoryMonitor::formatBytes(-1));
    }

    public function testUsageReturnsPositiveInt(): void
    {
        self::assertGreaterThan(0, MemoryMonitor::usage());
    }

    public function testPeakUsageIsAtLeastCurrentUsage(): void
    {
        self::assertGreaterThanOrEqual(MemoryMonitor::usage(), MemoryMonitor::peakUsage());
    }

    public function testAvailableMemoryReturnsIntOrUnlimited(): void
    {
        $available = MemoryMonitor::availableMemory();

        self::assertTrue($available === -1 || $available > 0);
    }

    public function testFormattedUsageContainsMemoryUsageLabel(): void
    {
        $formatted = MemoryMonitor::formattedUsage();

        self::assertStringStartsWith('Memory Usage:', $formatted);
        self::assertStringContainsString('/', $formatted);
    }

    public function testFormattedUsageWithContext(): void
    {
        $formatted = MemoryMonitor::formattedUsage('After loading worklist');

        self::assertStringStartsWith('After loading worklist - Memory Usage:', $formatted);
    }
}

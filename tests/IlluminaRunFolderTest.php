<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\IlluminaRunFolder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class IlluminaRunFolderTest extends TestCase
{
    public function testParseMiSeqI100(): void
    {
        $folder = IlluminaRunFolder::parse('20260205_SH01038_0007_ASC2139476-SC3');

        self::assertSame('2026-02-05', $folder->date->format('Y-m-d'));
        self::assertSame('SH01038', $folder->instrumentID);
        self::assertSame(7, $folder->runNumber);
        self::assertSame('ASC2139476-SC3', $folder->flowcellID);

    }

    public function testParseMiSeqWithZeroPrefixedFlowcell(): void
    {
        $folder = IlluminaRunFolder::parse('151231_M01261_0163_000000000-AGKG7');

        self::assertSame('2015-12-31', $folder->date->format('Y-m-d'));
        self::assertSame('M01261', $folder->instrumentID);
        self::assertSame(163, $folder->runNumber);
        self::assertSame('AGKG7', $folder->flowcellID);

    }

    public function testParseNextSeq(): void
    {
        $folder = IlluminaRunFolder::parse('160205_NB501352_0003_AH7LFFAFXX');

        self::assertSame('2016-02-05', $folder->date->format('Y-m-d'));
        self::assertSame('NB501352', $folder->instrumentID);
        self::assertSame(3, $folder->runNumber);
        self::assertSame('AH7LFFAFXX', $folder->flowcellID);

    }

    public function testParseMiSeqNanoFlowcell(): void
    {
        $folder = IlluminaRunFolder::parse('160315_M01111_0231_000000000-D0WDA');

        self::assertSame('D0WDA', $folder->flowcellID);

    }

    public function testParseBrokenRfidShortFlowcell(): void
    {
        $folder = IlluminaRunFolder::parse('160108_M01111_0222_AGKKL');

        self::assertSame('AGKKL', $folder->flowcellID);

    }

    public function testParseFromForwardSlashPath(): void
    {
        $folder = IlluminaRunFolder::parse('/data/sequencing/20260205_SH01038_0007_ASC2139476-SC3');

        self::assertSame('SH01038', $folder->instrumentID);
        self::assertSame('ASC2139476-SC3', $folder->flowcellID);
    }

    public function testParseFromBackslashPath(): void
    {
        $folder = IlluminaRunFolder::parse('miseq_active\260310_M02074_1219_000000000-MB4RJ');

        self::assertSame('2026-03-10', $folder->date->format('Y-m-d'));
        self::assertSame('M02074', $folder->instrumentID);
        self::assertSame(1219, $folder->runNumber);
        self::assertSame('B4RJ', $folder->flowcellID);

    }

    public function testParseRejectsInvalidPartCount(): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Expected format: YYYYMMDD_InstrumentID_RunNumber_FlowcellID.');
        IlluminaRunFolder::parse('20260205_SH01038_0007');
    }

    public function testParseRejectsInvalidDate(): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Expected 6 or 8 digit date.');
        IlluminaRunFolder::parse('not-a-date_SH01038_0007_ASC2139476-SC3');
    }

    /** @return iterable<array{string}> */
    public static function invalidRunNumbers(): iterable
    {
        yield ['20260205_SH01038__ASC2139476-SC3'];
        yield ['20260205_SH01038_abc_ASC2139476-SC3'];
    }

    /** @dataProvider invalidRunNumbers */
    #[DataProvider('invalidRunNumbers')]
    public function testParseRejectsInvalidRunNumber(string $value): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Expected a numeric value.');
        IlluminaRunFolder::parse($value);
    }

    public function testParseRejectsUnparsableFlowcellID(): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Cannot extract flowcell ID from: 12345');
        IlluminaRunFolder::parse('20260205_SH01038_0007_12345');
    }
}

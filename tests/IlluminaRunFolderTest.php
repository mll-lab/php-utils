<?php declare(strict_types=1);

use MLL\Utils\IlluminaRunFolder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class IlluminaRunFolderTest extends TestCase
{
    public function testParse(): void
    {
        $folder = IlluminaRunFolder::parse('20260205_SH01038_0007_ASC2139476-SC3');

        self::assertSame('2026-02-05', $folder->date->format('Y-m-d'));
        self::assertSame('SH01038', $folder->instrumentID);
        self::assertSame(7, $folder->runNumber);
        self::assertSame('ASC2139476-SC3', $folder->flowcellID);
    }

    public function testParseFromPath(): void
    {
        $folder = IlluminaRunFolder::parse('/data/sequencing/20260205_SH01038_0007_ASC2139476-SC3');

        self::assertSame('2026-02-05', $folder->date->format('Y-m-d'));
        self::assertSame('SH01038', $folder->instrumentID);
        self::assertSame(7, $folder->runNumber);
        self::assertSame('ASC2139476-SC3', $folder->flowcellID);
    }

    public function testToString(): void
    {
        $folder = IlluminaRunFolder::parse('20260205_SH01038_0007_ASC2139476-SC3');

        self::assertSame('20260205_SH01038_0007_ASC2139476-SC3', $folder->toString());
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
        self::expectExceptionMessage('Expected format: YYYYMMDD.');
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
}

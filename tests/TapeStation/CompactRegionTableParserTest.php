<?php declare(strict_types=1);

namespace MLL\Utils\Tests\TapeStation;

use MLL\Utils\TapeStation\CompactRegionTableParser;
use MLL\Utils\TapeStation\CompactRegionTableRecord;
use PHPUnit\Framework\TestCase;

final class CompactRegionTableParserTest extends TestCase
{
    public function testParseSemicolonDelimited(): void
    {
        $csv = <<<'CSV'
            FileName;WellId;Sample Description;From [bp];To [bp];Average Size [bp];Conc. [ng/µl];Region Molarity [nmol/l];% of Total;Region Comment
            2026-02-25 - 12.05.31.D1000;A1;Poko_FLT3-ITD_A1;200;1000;505;15.0;46.6;87.94;FLT3-ITD MRD
            2026-02-25 - 12.05.31.D1000;C1;Neko_FLT3-ITD_B1;200;1000;517;13.4;40.9;83.16;FLT3-ITD MRD
            CSV;

        $records = CompactRegionTableParser::parse($csv);

        self::assertCount(2, $records);

        $first = $records->first();
        self::assertInstanceOf(CompactRegionTableRecord::class, $first);
        self::assertSame('A1', $first->wellID);
        self::assertSame('Poko_FLT3-ITD_A1', $first->sampleDescription);
        self::assertSame(200, $first->fromBp);
        self::assertSame(1000, $first->toBp);
        self::assertSame(505, $first->averageSizeBp);
        self::assertSame(15.0, $first->concentrationNgPerUl);
        self::assertSame(46.6, $first->regionMolarityNmolPerL);
        self::assertEqualsWithDelta(87.94, $first->percentOfTotal, 0.01);
        self::assertSame('FLT3-ITD MRD', $first->regionComment);
    }

    public function testParseCommaDelimited(): void
    {
        $csv = <<<'CSV'
            FileName,WellId,Sample Description,From [bp],To [bp],Average Size [bp],Conc. [ng/µl],Region Molarity [nmol/l],% of Total,Region Comment
            2026-02-25.D1000,A8,22-000001,200,700,320,7.61,36.1,92.5,IDT
            CSV;

        $records = CompactRegionTableParser::parse($csv);

        self::assertCount(1, $records);

        $record = $records->first();
        self::assertInstanceOf(CompactRegionTableRecord::class, $record);
        self::assertSame('A8', $record->wellID);
        self::assertSame('22-000001', $record->sampleDescription);
        self::assertSame(320, $record->averageSizeBp);
        self::assertSame(7.61, $record->concentrationNgPerUl);
        self::assertSame(36.1, $record->regionMolarityNmolPerL);
    }

    public function testParseWithNtUnits(): void
    {
        $csv = <<<'CSV'
            FileName,WellId,Sample Description,From [nt],To [nt],Average Size [nt],Conc. [ng/µl],Region Molarity [nmol/l],% of Total,Region Comment
            export.D1000,B2,RNA_179_23-025829_F2,200,4000,1800,34.7,29.5,85.0,WTS
            CSV;

        $records = CompactRegionTableParser::parse($csv);

        self::assertCount(1, $records);

        $record = $records->first();
        self::assertInstanceOf(CompactRegionTableRecord::class, $record);
        self::assertSame(1800, $record->averageSizeBp);
        self::assertSame(34.7, $record->concentrationNgPerUl);
    }

    public function testParseWithCorruptedMuCharacter(): void
    {
        // The µ character (U+00B5) sometimes degrades to replacement character
        $corruptedHeader = "FileName;WellId;Sample Description;From [bp];To [bp];Average Size [bp];Conc. [ng/\xC2\xB5l];Region Molarity [nmol/l];% of Total;Region Comment";
        $csv = $corruptedHeader . "\n" . '2026-02-25.D1000;A1;Sample1;200;1000;500;12.5;38.0;90.0;MRD';

        $records = CompactRegionTableParser::parse($csv);

        self::assertCount(1, $records);
        $record = $records->first();
        self::assertInstanceOf(CompactRegionTableRecord::class, $record);
        self::assertSame(12.5, $record->concentrationNgPerUl);
    }

    public function testSkipsEmptyLines(): void
    {
        $csv = <<<'CSV'
            FileName;WellId;Sample Description;From [bp];To [bp];Average Size [bp];Conc. [ng/µl];Region Molarity [nmol/l];% of Total;Region Comment
            2026-02-25.D1000;A1;Sample1;200;1000;500;12.5;38.0;90.0;MRD

            2026-02-25.D1000;B1;Sample2;200;1000;490;8.3;25.1;85.0;MRD

            CSV;

        $records = CompactRegionTableParser::parse($csv);

        self::assertCount(2, $records);
    }

    public function testThrowsOnMissingConcentrationColumn(): void
    {
        $csv = <<<'CSV'
            FileName;WellId;Sample Description
            2026-02-25.D1000;A1;Sample1
            CSV;

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Concentration column not found');

        CompactRegionTableParser::parse($csv);
    }
}

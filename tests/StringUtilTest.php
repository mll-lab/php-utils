<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use Illuminate\Support\Collection;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class StringUtilTest extends TestCase
{
    /**
     * @dataProvider joinNonEmpty
     *
     * @param iterable<string|null> $parts
     */
    public function testJoinNonEmpty(string $expectedJoined, string $glue, iterable $parts): void
    {
        self::assertSame(
            $expectedJoined,
            StringUtil::joinNonEmpty($glue, $parts)
        );
    }

    /** @return iterable<array{string, string, iterable<string|null>}> */
    public static function joinNonEmpty(): iterable
    {
        yield ['a b', ' ', ['a', null, '', 'b']];
        yield ['ab', '', ['a', null, '', 'b']];
        yield ['a,b', ',', new Collection(['a', null, '', 'b'])];
    }

    /** @dataProvider shortenFirstname */
    public function testShortenFirstname(string $expectedShortened, string $input): void
    {
        self::assertSame(
            $expectedShortened,
            StringUtil::shortenFirstname($input)
        );
    }

    /** @return iterable<array{string, string}> */
    public static function shortenFirstname(): iterable
    {
        yield ['F.B.', 'Foo Bar'];
        yield ['F.X.', 'Fred-Xaver'];
        yield ['H.D.', 'H.F. Dieter'];
        yield ['H.', 'Hans'];
        yield ['', ''];
    }

    /**
     * @dataProvider splitLines
     *
     * @param array<int, string> $expectedLines
     */
    public function testSplitLines(array $expectedLines, string $input): void
    {
        self::assertSame($expectedLines, StringUtil::splitLines($input));
    }

    /** @return iterable<array{array<int, string>, string}> */
    public static function splitLines(): iterable
    {
        yield [[''], ''];
        yield [['foo'], 'foo'];
        yield [['foo', 'bar'], "foo\nbar"];
        yield [['foo', 'bar'], "foo\r\nbar"];
        yield [['foo', 'bar'], "foo\rbar"];
    }

    public function testNormalizeLineEndings(): void
    {
        $allPossibleEndings = "1 \r\n 2 \r 3 \n";
        self::assertSame(
            "1 \r\n 2 \r\n 3 \r\n",
            StringUtil::normalizeLineEndings($allPossibleEndings)
        );
        self::assertSame(
            "1 \n 2 \n 3 \n",
            StringUtil::normalizeLineEndings($allPossibleEndings, "\n")
        );
        self::assertSame(
            "1 \r 2 \r 3 \r",
            StringUtil::normalizeLineEndings($allPossibleEndings, "\r")
        );
    }

    public function testUTF8(): void
    {
        $expectedUTF8 = 'test';

        $string = \Safe\file_get_contents(__DIR__ . '/StringUtilTestData/UTF-8.csv');

        self::assertSame($expectedUTF8, $string);
        self::assertSame($expectedUTF8, StringUtil::toUTF8($string));
    }

    public function testUTF16LE(): void
    {
        // The zero width no-break space (ZWNBSP) is a deprecated use of the Unicode character at code point U+FEFF.
        // Character U+FEFF is intended for use as a Byte Order Mark (BOM) at the start of a file
        // -> https://unicode-explorer.com/c/FEFF
        $expectedUTF8 = '﻿test';

        $string = \Safe\file_get_contents(__DIR__ . '/StringUtilTestData/UTF-16LE.csv');
        self::assertNotSame($expectedUTF8, $string);
        self::assertSame($expectedUTF8, StringUtil::toUTF8($string));
    }

    public function testWindows1252(): void
    {
        $expectedUTF8 = <<<CSV
        FileName,WellID,Sample Description,From [bp],To [bp],Average Size [bp],Conc. [ng/µl],Region Molarity [nmol/l],% of Total,Region Comment
        2023-05-16 - 13.01.27.D1000,A12,RNA_191_23-049780_A1,170,550,312,23.7,121,95.50,IDT
        2023-05-16 - 13.01.27.D1000,B12,RNA_191_23-049782_B1,170,550,308,16.1,82.5,92.27,IDT
        2023-05-16 - 13.01.27.D1000,C12,RNA_191_23-049776_C1,170,550,310,16.7,85.3,93.76,IDT
        2023-05-16 - 13.01.27.D1000,D12,RNA_191_23-049778_D1,170,550,307,11.4,58.6,91.65,IDT
        2023-05-16 - 13.01.27.D1000,E12,RNA_191_NTC_E1,170,550,304,9.63,50.0,90.88,IDT

        CSV;

        $string = \Safe\file_get_contents(__DIR__ . '/StringUtilTestData/windows-1252.csv');
        self::assertNotSame($expectedUTF8, $string);

        $utf8String = StringUtil::toUTF8($string);
        self::assertSame(StringUtil::normalizeLineEndings($expectedUTF8), StringUtil::normalizeLineEndings($utf8String));
    }

    public function testLeftPadNumber(): void
    {
        self::assertSame(
            '00023',
            StringUtil::leftPadNumber(23, 5)
        );
        self::assertSame(
            '0',
            StringUtil::leftPadNumber(0, 1)
        );
        self::assertSame(
            '5',
            StringUtil::leftPadNumber(5, 1)
        );
        self::assertSame(
            '00',
            StringUtil::leftPadNumber(null, 2)
        );
        self::assertSame(
            '0034',
            StringUtil::leftPadNumber('34', 4)
        );

        self::expectException(\InvalidArgumentException::class);
        StringUtil::leftPadNumber('foo', 3);
    }

    public function testHasContent(): void
    {
        self::assertFalse(StringUtil::hasContent(null));
        self::assertFalse(StringUtil::hasContent(''));
        self::assertFalse(StringUtil::hasContent(' '));
        self::assertFalse(StringUtil::hasContent(' '));

        self::assertTrue(StringUtil::hasContent('foo'));
        self::assertTrue(StringUtil::hasContent(' bar '));
        self::assertTrue(StringUtil::hasContent('0'));
        self::assertTrue(StringUtil::hasContent('false'));
        self::assertTrue(StringUtil::hasContent(' null'));
    }
}

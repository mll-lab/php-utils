<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Unit;

use MLL\Utils\StringUtil;
use PHPUnit\Framework\TestCase;

final class StringUtilTest extends TestCase
{
    /**
     * @dataProvider shortenFirstname
     */
    public function testShortenFirstname(string $expectedShortened, string $input): void
    {
        self::assertSame(
            $expectedShortened,
            StringUtil::shortenFirstname($input)
        );
    }

    /**
     * @return iterable<array{string, string}>
     */
    public function shortenFirstname(): iterable
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

    /**
     * @return iterable<array{array<int, string>, string}>
     */
    public function splitLines(): iterable
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

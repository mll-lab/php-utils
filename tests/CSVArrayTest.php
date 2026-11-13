<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\CSVArray;
use MLL\Utils\StringUtil;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @phpstan-import-type CSVPrimitive from CSVArray
 */
final class CSVArrayTest extends TestCase
{
    /** @return iterable<array{string, array<int, array<string, string>>}> */
    public static function csvAndArrayStringValues(): iterable
    {
        yield [
            "Spalte1;Spalte2\r\n"
            . "Wert11;Wert21\r\n"
            . "Wert12;Wert22\r\n",
            [
                1 => [
                    'Spalte1' => 'Wert11',
                    'Spalte2' => 'Wert21',
                ],
                2 => [
                    'Spalte1' => 'Wert12',
                    'Spalte2' => 'Wert22',
                ],
            ],
        ];
        yield [
            "empty;int;float;bool;null\r\n"
            . ";1;2.3;true;null\r\n",
            [
                1 => [
                    'empty' => '',
                    'int' => '1',
                    'float' => '2.3',
                    'bool' => 'true',
                    'null' => 'null',
                ],
            ],
        ];
    }

    /**
     * @dataProvider csvAndArrayStringValues
     *
     * @param array<int, array<string, string>> $array
     */
    #[DataProvider('csvAndArrayStringValues')]
    public function testStringValues(string $csv, array $array): void
    {
        self::assertSame($array, CSVArray::toArray($csv));
        self::assertSame($csv, CSVArray::toCSV($array));
    }

    public function testEscapesDelimiter(): void
    {
        self::assertSame(
            "foo\r\n"
            . "\"bar;baz\"\r\n",
            CSVArray::toCSV(
                [
                    1 => [
                        'foo' => 'bar;baz',
                    ],
                ]
            )
        );
    }

    public function testUnixLike(): void
    {
        self::assertSame(
            <<<CSV
            foo,bar
            1,2

            CSV,
            CSVArray::toCSV(
                [
                    [
                        'foo' => 1,
                        'bar' => 2,
                    ],
                ],
                ',',
                "\n"
            )
        );
    }

    public function testPrimitives(): void
    {
        self::assertSame(
            "empty;int;float;bool;null\r\n"
            . ";1;2.3;1;\r\n",
            CSVArray::toCSV(
                [
                    1 => [
                        'empty' => '',
                        'int' => 1,
                        'float' => 2.3,
                        'bool' => true,
                        'null' => null,
                    ],
                ],
            ),
        );
    }

    public function testToArrayOptionalParameters(): void
    {
        self::assertSame(
            [
                1 => [
                    'foo' => 'bar,baz',
                    'bar' => 'ba\\',
                ],
            ],
            CSVArray::toArray(
                "foo,bar\r\n"
                . "%bar,baz%,ba\\\r\n",
                ',',
                '%',
                '~'
            )
        );
    }

    public function testToArrayDefaultsMissingColumnsToEmptyStrings(): void
    {
        self::assertSame(
            [
                1 => [
                    'Spalte1' => 'Wert11',
                    'Spalte2' => 'Wert21',
                ],
                2 => [
                    'Spalte1' => 'Wert12',
                    'Spalte2' => CSVArray::DEFAULT_EMPTY_VALUE,
                ],
                3 => [
                    'Spalte1' => '',
                    'Spalte2' => '',
                ],
                5 => [
                    'Spalte1' => 'Wert14',
                    'Spalte2' => 'Wert24',
                ],
            ],
            CSVArray::toArray(
                "Spalte1;Spalte2\r\n"
                . "Wert11;Wert21\r\n"
                . "Wert12\r\n"
                . ";\r\n"
                . StringUtil::WINDOWS_NEWLINE
                . 'Wert14;Wert24;Wert34'
                . StringUtil::WINDOWS_NEWLINE
            )
        );
    }

    /** @return iterable<string, array{string, array<int, array<string, string>>}> */
    public static function lineBreakVariants(): iterable
    {
        yield 'carriage return only' => [
            "a;b\rx;y\r1;2\r",
            [
                1 => ['a' => 'x', 'b' => 'y'],
                2 => ['a' => '1', 'b' => '2'],
            ],
        ];
        yield 'mixed line breaks' => [
            "a;b\rx;y\n1;2\r\n",
            [
                1 => ['a' => 'x', 'b' => 'y'],
                2 => ['a' => '1', 'b' => '2'],
            ],
        ];
        yield 'carriage return only with line feed in enclosed field' => [
            "a;b\rx;\"hello\nworld\"\r1;2\r",
            [
                1 => ['a' => 'x', 'b' => "hello\nworld"],
                2 => ['a' => '1', 'b' => '2'],
            ],
        ];
        yield 'vertical tab before enclosure' => [
            "a;b\n\v\"first\nsecond\";x\n",
            [
                1 => ['a' => "first\nsecond", 'b' => 'x'],
            ],
        ];
        yield 'enclosed empty value in single column' => [
            "name\r\n\"\"\r\nBob\r\n",
            [
                1 => ['name' => ''],
                2 => ['name' => 'Bob'],
            ],
        ];
        yield 'escaped enclosure in multiline field' => [
            "a;b\r\nx;\"say \\\"hi\r\nthere\"\r\n1;2\r\n",
            [
                1 => ['a' => 'x', 'b' => "say \\\"hi\r\nthere"],
                2 => ['a' => '1', 'b' => '2'],
            ],
        ];
    }

    /** @return iterable<string, array{string, array<int, array<string, string>>}> */
    public static function enclosuresOutsideEnclosedFields(): iterable
    {
        yield 'inch mark in unenclosed field' => [
            "size;name\r\n12\";Disk\r\n14;Other\r\n",
            [
                1 => ['size' => '12"', 'name' => 'Disk'],
                2 => ['size' => '14', 'name' => 'Other'],
            ],
        ];
        yield 'text after closing enclosure' => [
            "a;b\r\n\"x\"y\";z\r\n1;2\r\n",
            [
                1 => ['a' => 'xy"', 'b' => 'z'],
                2 => ['a' => '1', 'b' => '2'],
            ],
        ];
        yield 'escaped enclosure in unenclosed field' => [
            "a;b\r\nx\\\";z\r\n1;2\r\n",
            [
                1 => ['a' => 'x\\"', 'b' => 'z'],
                2 => ['a' => '1', 'b' => '2'],
            ],
        ];
    }

    /**
     * @dataProvider enclosuresOutsideEnclosedFields
     *
     * @param array<int, array<string, string>> $array
     */
    #[DataProvider('enclosuresOutsideEnclosedFields')]
    public function testToArrayTreatsEnclosuresOutsideEnclosedFieldsAsText(string $csv, array $array): void
    {
        self::assertSame($array, CSVArray::toArray($csv));
    }

    public function testToArrayWithLineFeedAsEscape(): void
    {
        self::assertSame(
            [
                1 => ['a' => 'x', 'b' => "hello\n\"world\nend"],
            ],
            CSVArray::toArray("a;b\nx;\"hello\n\"world\nend\"\n", ';', '"', "\n")
        );
    }

    public function testToArrayWithEscapeEqualToEnclosure(): void
    {
        self::assertSame(
            [
                1 => ['a' => 'x"y', 'b' => 'z'],
                2 => ['a' => "m\r\nn", 'b' => '2'],
            ],
            CSVArray::toArray("a;b\r\n\"x\"\"y\";z\r\n\"m\r\nn\";2\r\n", ';', '"', '"')
        );
    }

    /**
     * @dataProvider lineBreakVariants
     *
     * @param array<int, array<string, string>> $array
     */
    #[DataProvider('lineBreakVariants')]
    public function testToArrayHandlesLineBreakVariants(string $csv, array $array): void
    {
        self::assertSame($array, CSVArray::toArray($csv));
    }

    public function testToArrayYieldsNoRecordsForEmptyCSV(): void
    {
        self::assertSame([], CSVArray::toArray(''));
    }

    public function testHandlesMultilineStrings(): void
    {
        $multilineCsv = <<<CSV
            h1;h2\r
            a1;"multi\r
            line\r
            content"\r
            "more\r
            multi";b2\r

            CSV;

        $multilineArray = [
            1 => [
                'h1' => 'a1',
                'h2' => <<<STR
                    multi\r
                    line\r
                    content
                    STR,
            ],
            2 => [
                'h1' => <<<STR
                    more\r
                    multi
                    STR,
                'h2' => 'b2',
            ],
        ];

        self::assertSame($multilineCsv, CSVArray::toCSV($multilineArray));

        self::assertSame($multilineArray, CSVArray::toArray($multilineCsv));
    }
}

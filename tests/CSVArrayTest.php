<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use MLL\Utils\CSVArray;
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
                . "\r\n"
                . 'Wert14;Wert24;Wert34'
                . "\r\n"
            )
        );
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

        self::markTestIncomplete('This does not work correctly yet');
        // @phpstan-ignore-next-line https://github.com/phpstan/phpstan-phpunit/issues/52
        self::assertSame($multilineArray, CSVArray::toArray($multilineCsv));
    }
}

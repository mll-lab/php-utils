<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Unit;

use MLL\Utils\CSVArray;
use PHPUnit\Framework\TestCase;

class CSVArrayTest extends TestCase
{
    public const ARRAY_CONTENT = [
        1 => [
            'Spalte1' => 'Wert11',
            'Spalte2' => 'Wert21',
        ],
        2 => [
            'Spalte1' => 'Wert12',
            'Spalte2' => 'Wert22',
        ],
    ];

    public const CSV_CONTENT
          = "Spalte1;Spalte2\r\n"
        . "Wert11;Wert21\r\n"
        . "Wert12;Wert22\r\n";

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testToArray(): void
    {
        self::assertSame(
            self::ARRAY_CONTENT,
            CSVArray::toArray(self::CSV_CONTENT)
        );
    }

    public function testToCSV(): void
    {
        self::assertSame(
            self::CSV_CONTENT,
            CSVArray::toCSV(self::ARRAY_CONTENT)
        );
    }

    public function testToCSVAndToArrayAreInverse(): void
    {
        self::assertSame(
            self::ARRAY_CONTENT,
            CSVArray::toArray(
                CSVArray::toCSV(self::ARRAY_CONTENT)
            )
        );

        self::assertSame(
            self::CSV_CONTENT,
            CSVArray::toCSV(
                CSVArray::toArray(self::CSV_CONTENT)
            )
        );
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

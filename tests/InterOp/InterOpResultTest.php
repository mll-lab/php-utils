<?php declare(strict_types=1);

namespace MLL\Utils\Tests\InterOp;

use MLL\Utils\InterOp\InterOpResult;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class InterOpResultTest extends TestCase
{
    /**
     * @dataProvider dataReadDetectionProvider
     *
     * @param array<int, array<string, string>> $summary
     */
    #[DataProvider('dataReadDetectionProvider')]
    public function testFindDataReads(string $description, array $summary, string $expectedFirst, string $expectedLast): void
    {
        [$first, $last] = InterOpResult::findDataReads($summary);

        self::assertSame($expectedFirst, $first, "{$description}: first data read");
        self::assertSame($expectedLast, $last, "{$description}: last data read");
    }

    /** @return iterable<string, array{description: string, summary: array<int, array<string, string>>, expectedFirst: string, expectedLast: string}> */
    public static function dataReadDetectionProvider(): iterable
    {
        yield 'MiSeq single-index' => [
            'description' => 'MiSeq with one index read',
            'summary' => [
                ['Level' => 'Read 1'],
                ['Level' => 'Read 2 (I)'],
                ['Level' => 'Read 3'],
                ['Level' => 'Non-indexed'],
                ['Level' => 'Total'],
            ],
            'expectedFirst' => 'Read 1',
            'expectedLast' => 'Read 3',
        ];

        yield 'MiSeq dual-index' => [
            'description' => 'MiSeq with two index reads',
            'summary' => [
                ['Level' => 'Read 1'],
                ['Level' => 'Read 2 (I)'],
                ['Level' => 'Read 3 (I)'],
                ['Level' => 'Read 4'],
                ['Level' => 'Non-indexed'],
                ['Level' => 'Total'],
            ],
            'expectedFirst' => 'Read 1',
            'expectedLast' => 'Read 4',
        ];

        yield 'i100 dual-index' => [
            'description' => 'i100 with index reads first',
            'summary' => [
                ['Level' => 'Read 1 (I)'],
                ['Level' => 'Read 2 (I)'],
                ['Level' => 'Read 3'],
                ['Level' => 'Read 4'],
                ['Level' => 'Non-indexed'],
                ['Level' => 'Total'],
            ],
            'expectedFirst' => 'Read 3',
            'expectedLast' => 'Read 4',
        ];
    }
}

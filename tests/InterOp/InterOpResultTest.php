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

    /** @return iterable<string, array{string, array<int, array<string, string>>, string, string}> */
    public static function dataReadDetectionProvider(): iterable
    {
        yield 'MiSeq single-index' => [
            'MiSeq with one index read',
            [
                ['Level' => 'Read 1'],
                ['Level' => 'Read 2 (I)'],
                ['Level' => 'Read 3'],
                ['Level' => 'Non-indexed'],
                ['Level' => 'Total'],
            ],
            'Read 1',
            'Read 3',
        ];

        yield 'MiSeq dual-index' => [
            'MiSeq with two index reads',
            [
                ['Level' => 'Read 1'],
                ['Level' => 'Read 2 (I)'],
                ['Level' => 'Read 3 (I)'],
                ['Level' => 'Read 4'],
                ['Level' => 'Non-indexed'],
                ['Level' => 'Total'],
            ],
            'Read 1',
            'Read 4',
        ];

        yield 'i100 dual-index' => [
            'i100 with index reads first',
            [
                ['Level' => 'Read 1 (I)'],
                ['Level' => 'Read 2 (I)'],
                ['Level' => 'Read 3'],
                ['Level' => 'Read 4'],
                ['Level' => 'Non-indexed'],
                ['Level' => 'Total'],
            ],
            'Read 3',
            'Read 4',
        ];
    }
}

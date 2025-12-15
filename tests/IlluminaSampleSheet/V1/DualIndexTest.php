<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V1\DualIndex;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class DualIndexTest extends TestCase
{
    #[DataProvider('provideValidDualIndexes')]
    public function testValidate(
        string $i7IndexID,
        string $index,
        string $i5IndexID,
        string $index2,
        bool $isValid,
        ?string $invalidIndexValue = null
    ): void {
        if (! $isValid) {
            $this->expectException(IlluminaSampleSheetException::class);
            if ($index === '' || $index === '0' || ($index2 === '' || $index2 === '0')) {
                $this->expectExceptionMessage('Index must not be an empty string.');
            } else {
                $this->expectExceptionMessage("Index '{$invalidIndexValue}' contains invalid characters. Only A, T, C, G, N are allowed.");
            }
        } else {
            $this->expectNotToPerformAssertions();
        }

        new DualIndex($i7IndexID, $index, $i5IndexID, $index2);
    }

    /** @return iterable<string, array<int, string|bool|null>> */
    public static function provideValidDualIndexes(): iterable
    {
        yield 'Both indices valid long' => ['someIndexID', 'ATCGNGTANGT', 'someOtherIndexID', 'ATGNAAATTTTAC', true];
        yield 'Both indices valid short' => ['someIndexID', 'A', 'someOtherIndexID', 'G', true];
        yield 'Both indices invalid' => ['i7IndexID', 'invalidValue', 'i5IndexID', 'invalidValue2', false, 'invalidValue'];
        yield 'First index invalid' => ['i7IndexID', 'invalidValue', 'i5IndexID', 'ATCGNGT', false, 'invalidValue'];
        yield 'Second index invalid' => ['i7IndexID', 'ATCGNGT', 'i5IndexID', 'invalidValue2', false, 'invalidValue2'];
        yield 'First index empty' => ['someIndexID', '', 'someOtherIndexID', 'ATGNAAAC', false, ''];
        yield 'Second index empty' => ['someIndexID', 'ATCGNGT', 'someOtherIndexID', '', false, ''];
    }
}

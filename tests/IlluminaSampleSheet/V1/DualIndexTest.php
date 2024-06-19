<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\V1\DualIndex;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DualIndexTest extends TestCase
{
    /** @dataProvider provideValidDualIndexes */
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

    /** @return array<string, array<int, string|bool|null>> */
    public static function provideValidDualIndexes(): array
    {
        return [
            'Both indices valid long' => ['someIndexID', 'ATCGNGTANGT', 'someOtherIndexID', 'ATGNAAATTTTAC', true],
            'Both indices valid short' => ['someIndexID', 'A', 'someOtherIndexID', 'G', true],
            'Both indices invalid' => ['i7IndexID', 'invalidValue', 'i5IndexID', 'invalidValue2', false, 'invalidValue'],
            'First index invalid' => ['i7IndexID', 'invalidValue', 'i5IndexID', 'ATCGNGT', false, 'invalidValue'],
            'Second index invalid' => ['i7IndexID', 'ATCGNGT', 'i5IndexID', 'invalidValue2', false, 'invalidValue2'],
            'First index empty' => ['someIndexID', '', 'someOtherIndexID', 'ATGNAAAC', false, ''],
            'Second index empty' => ['someIndexID', 'ATCGNGT', 'someOtherIndexID', '', false, ''],
        ];
    }
}

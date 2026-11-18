<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPUnit;

use Illuminate\Support\Collection;
use MLL\Utils\PHPUnit\AssertsIterableValues;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

final class AssertsIterableValuesTest extends TestCase
{
    use AssertsIterableValues;

    public function testIgnoresKeys(): void
    {
        self::assertIterablesHaveIdenticalValues(['a', 'b'], [3 => 'a', 'x' => 'b']);
    }

    public function testAcceptsCollectionsAndGenerators(): void
    {
        $generator = (static function (): \Generator {
            yield 'k' => 'a';
            yield 'k' => 'b';
        })();

        self::assertIterablesHaveIdenticalValues(new Collection([1 => 'a', 0 => 'b']), $generator);
    }

    public function testFailsOnDifferentOrder(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::assertIterablesHaveIdenticalValues(['a', 'b'], ['b', 'a']);
    }

    public function testFailsOnLooseEquality(): void
    {
        $this->expectException(AssertionFailedError::class);
        self::assertIterablesHaveIdenticalValues([1], ['1']);
    }
}

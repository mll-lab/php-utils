<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use MLL\Utils\PHPStan\Rules\ClassNameIdToIDRule;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ClassNameIdToIDRuleTest extends TestCase
{
    /** @dataProvider wrongToRight */
    #[DataProvider('wrongToRight')]
    public function testFixIDCapitalization(string $wrong, string $right): void
    {
        self::assertSame($right, ClassNameIdToIDRule::fixIDCapitalization($wrong));
    }

    /** @return iterable<array{string, string}> */
    public static function wrongToRight(): iterable
    {
        yield ['Id', 'ID'];
        yield ['IdProvider', 'IDProvider'];
        yield ['labId', 'labID'];
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\Rules;

use MLL\Utils\PHPStan\Rules\NameIdToIDRule;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class NameIdToIDRuleTest extends TestCase
{
    /** @dataProvider wrongID */
    #[DataProvider('wrongID')]
    public function testRecognizesWrongCapitalizations(string $variableName): void
    {
        self::assertTrue(NameIdToIDRule::containsWrongIDCapitalization($variableName));
    }

    /** @return iterable<array{string}> */
    public static function wrongID(): iterable
    {
        yield ['Id'];
        yield ['labId'];
        yield ['labIds'];
    }

    /** @dataProvider correctID */
    #[DataProvider('correctID')]
    public function testAllowsCorrectCapitalizations(string $variableName): void
    {
        self::assertFalse(NameIdToIDRule::containsWrongIDCapitalization($variableName));
    }

    /** @return iterable<array{string}> */
    public static function correctID(): iterable
    {
        yield ['id'];
        yield ['ids'];
        yield ['test_id'];
        yield ['labID'];
        yield ['labIDs'];
        yield ['testIdentifier'];
        yield ['openIdtAnalyses'];
    }

    /** @dataProvider wrongToRight */
    #[DataProvider('wrongToRight')]
    public function testFixIDCapitalization(string $wrong, string $right): void
    {
        self::assertSame($right, NameIdToIDRule::fixIDCapitalization($wrong));
    }

    /** @return iterable<array{string, string}> */
    public static function wrongToRight(): iterable
    {
        yield ['Id', 'id'];
        yield ['labId', 'labID'];
        yield ['labIds', 'labIDs'];
    }
}

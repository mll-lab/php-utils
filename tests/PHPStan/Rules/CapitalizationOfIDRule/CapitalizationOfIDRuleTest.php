<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\Rules\CapitalizationOfIDRule;

use MLL\Utils\PHPStan\Rules\CapitalizationOfIDRule;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CapitalizationOfIDRuleTest extends TestCase
{
    /** @dataProvider wrongID */
    #[DataProvider('wrongID')]
    public function testRecognizesWrongCapitalizations(string $variableName): void
    {
        self::assertTrue(CapitalizationOfIDRule::containsWrongIDCapitalization($variableName));
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
        self::assertFalse(CapitalizationOfIDRule::containsWrongIDCapitalization($variableName));
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
        yield ['isIdenticalThing'];
    }

    /** @dataProvider wrongToRight */
    #[DataProvider('wrongToRight')]
    public function testFixIDCapitalization(string $wrong, string $right): void
    {
        self::assertSame($right, CapitalizationOfIDRule::fixIDCapitalization($wrong));
    }

    /** @return iterable<array{string, string}> */
    public static function wrongToRight(): iterable
    {
        yield ['Id', 'id'];
        yield ['labId', 'labID'];
        yield ['labIds', 'labIDs'];
    }
}

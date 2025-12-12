<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use MLL\Utils\PHPStan\Rules\IdToIDRule;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class IdToIDRuleTest extends TestCase
{
    /** @dataProvider wrongID */
    #[DataProvider('wrongID')]
    public function testRecognizesWrongCapitalizations(string $variableName): void
    {
        self::assertTrue(IdToIDRule::containsWrongIDCapitalization($variableName));
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
        self::assertFalse(IdToIDRule::containsWrongIDCapitalization($variableName));
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
        yield ['openIdtPanelAnalyses'];
        yield ['isIdenticalThing'];
        yield ['hasIdentity'];
    }

    /** @dataProvider wrongToRight */
    #[DataProvider('wrongToRight')]
    public function testFixIDCapitalization(string $wrong, string $right): void
    {
        self::assertSame($right, IdToIDRule::fixIDCapitalization($wrong));
    }

    /** @return iterable<array{string, string}> */
    public static function wrongToRight(): iterable
    {
        yield ['Id', 'id'];
        yield ['IdProvider', 'idProvider'];
        yield ['IdToSomething', 'idToSomething'];
        yield ['labId', 'labID'];
        yield ['labIds', 'labIDs'];
    }
}

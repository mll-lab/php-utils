<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use MLL\Utils\PHPStan\Rules\LabIDCapitalizationRule;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LabIDCapitalizationRuleTest extends TestCase
{
    private LabIDCapitalizationRule $rule;

    protected function setUp(): void
    {
        $this->rule = new LabIDCapitalizationRule();
    }

    /** @dataProvider wrongCapitalizations */
    #[DataProvider('wrongCapitalizations')]
    public function testDetectsWrongCapitalizations(string $input, string $wrongVariant, string $expected): void
    {
        $findWrongVariant = new \ReflectionMethod($this->rule, 'findWrongVariant');
        $fixCapitalization = new \ReflectionMethod($this->rule, 'fixCapitalization');

        self::assertSame($wrongVariant, $findWrongVariant->invoke($this->rule, $input));
        self::assertSame($expected, $fixCapitalization->invoke($this->rule, $input, $wrongVariant));
    }

    /** @return iterable<array{string, string, string}> */
    public static function wrongCapitalizations(): iterable
    {
        yield 'LabID in variable' => ['getLabID', 'LabID', 'getLab ID'];
        yield 'labID in variable' => ['labIDValue', 'labID', 'Lab IDValue'];
        yield 'LABID uppercase' => ['LABID_CONSTANT', 'LABID', 'Lab ID_CONSTANT'];
        yield 'Labid mixed' => ['Labid', 'Labid', 'Lab ID'];
        yield 'Lab-ID with hyphen' => ['Lab-ID', 'Lab-ID', 'Lab ID'];
        yield 'Lab Id wrong case' => ['Lab Id', 'Lab Id', 'Lab ID'];
        yield 'In string literal' => ['The LabID is wrong', 'LabID', 'The Lab ID is wrong'];
    }

    /** @dataProvider correctCapitalizations */
    #[DataProvider('correctCapitalizations')]
    public function testAllowsCorrectCapitalizations(string $input): void
    {
        $findWrongVariant = new \ReflectionMethod($this->rule, 'findWrongVariant');

        self::assertNull($findWrongVariant->invoke($this->rule, $input));
    }

    /** @return iterable<array{string}> */
    public static function correctCapitalizations(): iterable
    {
        yield 'Correct Lab ID' => ['Lab ID'];
        yield 'In sentence' => ['The Lab ID is correct'];
        yield 'labID as variable (camelCase)' => ['labId']; // This is ID capitalization, not Lab ID
        yield 'Unrelated' => ['Laboratory'];
    }
}

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
        $findWrongVariant->setAccessible(true);
        $fixCapitalization = new \ReflectionMethod($this->rule, 'fixCapitalization');
        $fixCapitalization->setAccessible(true);

        self::assertSame($wrongVariant, $findWrongVariant->invoke($this->rule, $input));
        self::assertSame($expected, $fixCapitalization->invoke($this->rule, $input, $wrongVariant));
    }

    /** @return iterable<array{string, string, string}> */
    public static function wrongCapitalizations(): iterable
    {
        yield 'LabID' => ['The LabID is wrong', 'LabID', 'The Lab ID is wrong'];
        yield 'labID' => ['Your labID was submitted', 'labID', 'Your Lab ID was submitted'];
        yield 'LABID' => ['LABID not found', 'LABID', 'Lab ID not found'];
        yield 'Labid' => ['Labid missing', 'Labid', 'Lab ID missing'];
        yield 'Lab-ID with hyphen' => ['Enter Lab-ID here', 'Lab-ID', 'Enter Lab ID here'];
        yield 'Lab Id wrong case' => ['Lab Id is required', 'Lab Id', 'Lab ID is required'];
    }

    /** @dataProvider correctCapitalizations */
    #[DataProvider('correctCapitalizations')]
    public function testAllowsCorrectCapitalizations(string $input): void
    {
        $findWrongVariant = new \ReflectionMethod($this->rule, 'findWrongVariant');
        $findWrongVariant->setAccessible(true);

        self::assertNull($findWrongVariant->invoke($this->rule, $input));
    }

    /** @return iterable<array{string}> */
    public static function correctCapitalizations(): iterable
    {
        yield 'Correct Lab ID' => ['Lab ID'];
        yield 'In sentence' => ['The Lab ID is correct'];
        yield 'labId lowercase' => ['labId']; // This is ID capitalization, not Lab ID
        yield 'Unrelated word' => ['Laboratory'];
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use PHPUnit\Framework\Attributes\DataProvider;

final class IdToIDRuleIntegrationTest extends PHPStanIntegrationTestCase
{
    private const ERROR_PATTERN = 'should use "ID" instead of "Id"';

    /** @return iterable<array{0: string, 1: array<int, array<int, string>>}> */
    public static function dataIntegrationTests(): iterable
    {
        self::getContainer();

        yield 'wrong capitalization' => [__DIR__ . '/data/wrong-capitalization.php', [
            5 => [
                'Name of Stmt_Class "LabIdProcessor" should use "ID" instead of "Id", rename it to "LabIDProcessor".',
            ],
            7 => [
                'Name of Stmt_ClassMethod "getLabId" should use "ID" instead of "Id", rename it to "getLabID".',
            ],
            12 => [
                'Name of Stmt_ClassMethod "processLabId" should use "ID" instead of "Id", rename it to "processLabID".',
                'Name of Param "$labId" should use "ID" instead of "Id", rename it to "$labID".',
            ],
            14 => [
                'Name of Expr_Variable "$sampleId" should use "ID" instead of "Id", rename it to "$sampleID".',
                'Name of Expr_Variable "$labId" should use "ID" instead of "Id", rename it to "$labID".',
            ],
        ]];

        yield 'correct capitalization' => [__DIR__ . '/data/correct-capitalization.php', []];
    }

    /**
     * @param array<int, array<int, string>> $expectedErrors
     *
     * @dataProvider dataIntegrationTests
     */
    #[DataProvider('dataIntegrationTests')]
    public function testIntegration(string $file, array $expectedErrors): void
    {
        $errors = $this->analyseFile($file);
        $filteredErrors = $this->filterErrors($errors, self::ERROR_PATTERN);

        if ($expectedErrors === []) {
            self::assertEmpty($filteredErrors, 'Should not report errors for correct capitalization');
        } else {
            self::assertNotEmpty($filteredErrors, 'Should detect wrong capitalization');
            $this->assertExpectedErrors($expectedErrors, $filteredErrors);
        }
    }
}

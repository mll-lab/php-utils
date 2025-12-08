<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use PHPStan\Analyser\Analyser;
use PHPStan\Analyser\Error;
use PHPStan\Testing\PHPStanTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @requires PHP >= 8.3
 */
final class LabIDCapitalizationRuleIntegrationTest extends PHPStanTestCase
{
    /** @return iterable<string, array{0: array<int, array<int, string>>}> */
    public static function dataIntegrationTests(): iterable
    {
        self::getContainer();

        yield 'lab-id-capitalization fixture' => [[
            // Line 9: 'The LabID is wrong' - wrong capitalization
            9 => ['String "The LabID is wrong" should use "Lab ID" instead of "LabID", change it to "The Lab ID is wrong".'],
            // Lines 30-36: GraphQL query WITHOUT @lang annotation - wrong capitalization
            30 => ['String "' . "\n            {\n                patient {\n                    labID\n                }\n            }\n        " . '" should use "Lab ID" instead of "labID", change it to "' . "\n            {\n                patient {\n                    Lab ID\n                }\n            }\n        " . '".'],
            // Lines 66-72: SQL query WITHOUT @lang annotation - wrong capitalization
            68 => ['String "' . "\n            SELECT exam_no AS labID\n            FROM examinations\n        " . '" should use "Lab ID" instead of "labID", change it to "' . "\n            SELECT exam_no AS Lab ID\n            FROM examinations\n        " . '".'],
        ]];
    }

    /**
     * @param array<int, array<int, string>> $expectedErrors
     *
     * @dataProvider dataIntegrationTests
     */
    #[DataProvider('dataIntegrationTests')]
    public function testIntegration(array $expectedErrors): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');

        $labIDErrors = array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), 'should use "Lab ID"'),
        );

        if ($expectedErrors === []) {
            self::assertEmpty($labIDErrors, 'Should not report errors for correct capitalization');
        } else {
            self::assertNotEmpty($labIDErrors, 'Should detect wrong Lab ID capitalization');
            $this->assertSameErrorMessages($expectedErrors, $labIDErrors);
        }
    }

    public function testIgnoresCorrectCapitalization(): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');
        $errorLines = $this->getErrorLines($errors);

        // Line 14: 'The Lab ID is correct' - should NOT be detected
        self::assertNotContains(14, $errorLines, 'Should not report correct Lab ID capitalization');
    }

    public function testIgnoresGraphQLQueryWithAnnotation(): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');
        $errorLines = $this->getErrorLines($errors);

        // Lines 18-25: GraphQL query WITH @lang annotation - should NOT be detected
        $graphqlAnnotatedErrors = array_filter(
            $errorLines,
            static fn (int $line): bool => $line >= 18 && $line <= 25,
        );

        self::assertEmpty($graphqlAnnotatedErrors, 'Should ignore GraphQL query with @lang annotation');
    }

    public function testIgnoresIdentifierStrings(): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');
        $errorLines = $this->getErrorLines($errors);

        // Lines 44-45: Array keys 'labID', 'LabID' - should NOT be detected (identifier-like)
        self::assertNotContains(44, $errorLines, 'Should not report array key labID');
        self::assertNotContains(45, $errorLines, 'Should not report array key LabID');

        // Line 52: Single identifier string 'labID' - should NOT be detected
        self::assertNotContains(52, $errorLines, 'Should not report identifier string labID');
    }

    public function testIgnoresSqlQueryWithAnnotation(): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');
        $errorLines = $this->getErrorLines($errors);

        // Lines 57-64: SQL query WITH @lang annotation - should NOT be detected
        $sqlAnnotatedErrors = array_filter(
            $errorLines,
            static fn (int $line): bool => $line >= 57 && $line <= 64,
        );

        self::assertEmpty($sqlAnnotatedErrors, 'Should ignore SQL query with @lang annotation');
    }

    /** @return array<Error> */
    private function runAnalyse(string $file): array
    {
        $file = self::getFileHelper()->normalizePath($file);

        /** @var Analyser $analyser */
        $analyser = self::getContainer()->getByType(Analyser::class);

        $result = $analyser->analyse([$file]);

        return $result->getErrors();
    }

    /**
     * @param array<Error> $errors
     *
     * @return array<int>
     */
    private function getErrorLines(array $errors): array
    {
        $labIDErrors = array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), 'should use "Lab ID"'),
        );

        return array_map(
            static fn (Error $error): int => $error->getLine() ?? 0,
            $labIDErrors,
        );
    }

    /**
     * @param array<int, array<int, string>> $expectedErrors
     * @param array<Error> $errors
     */
    private function assertSameErrorMessages(array $expectedErrors, array $errors): void
    {
        foreach ($errors as $error) {
            $errorLine = $error->getLine() ?? 0;
            $errorMessage = $error->getMessage();

            self::assertArrayHasKey($errorLine, $expectedErrors, "Unexpected error at line {$errorLine}: {$errorMessage}");
            self::assertContains($errorMessage, $expectedErrors[$errorLine]);
        }
    }

    /** @return array<string> */
    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/phpstan-test.neon',
        ];
    }
}

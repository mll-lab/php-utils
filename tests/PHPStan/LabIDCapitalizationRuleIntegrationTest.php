<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use PHPStan\Analyser\Analyser;
use PHPStan\Analyser\Error;
use PHPStan\Testing\PHPStanTestCase;

/**
 * @requires PHP >= 8.3
 */
final class LabIDCapitalizationRuleIntegrationTest extends PHPStanTestCase
{
    public function testDetectsWrongCapitalizationInString(): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');

        $labIDErrors = array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), 'should use "Lab ID"'),
        );

        self::assertNotEmpty($labIDErrors, 'Should detect wrong capitalization in strings');

        $errorLines = array_map(
            static fn (Error $error): int => $error->getLine() ?? 0,
            $labIDErrors,
        );

        // Line 9: 'The LabID is wrong' - should be detected
        self::assertContains(9, $errorLines, 'Should detect LabID on line 9');

        // Line 30-35: GraphQL query WITHOUT @lang annotation - should be detected
        self::assertTrue(
            count(array_filter($errorLines, static fn (int $line): bool => $line >= 29 && $line <= 36)) > 0,
            'Should detect labID in GraphQL query without @lang annotation',
        );
    }

    public function testIgnoresGraphQLQueryWithAnnotation(): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');

        $labIDErrors = array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), 'should use "Lab ID"'),
        );

        $errorLines = array_map(
            static fn (Error $error): int => $error->getLine() ?? 0,
            $labIDErrors,
        );

        // Lines 18-25: GraphQL query WITH @lang annotation - should NOT be detected
        $graphqlAnnotatedErrors = array_filter(
            $errorLines,
            static fn (int $line): bool => $line >= 18 && $line <= 25,
        );

        self::assertEmpty($graphqlAnnotatedErrors, 'Should ignore GraphQL query with @lang annotation');
    }

    public function testIgnoresCorrectCapitalization(): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');

        $labIDErrors = array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), 'should use "Lab ID"'),
        );

        $errorLines = array_map(
            static fn (Error $error): int => $error->getLine() ?? 0,
            $labIDErrors,
        );

        // Line 14: 'The Lab ID is correct' - should NOT be detected
        self::assertNotContains(14, $errorLines, 'Should not report correct Lab ID capitalization');
    }

    public function testIgnoresIdentifierStrings(): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');

        $labIDErrors = array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), 'should use "Lab ID"'),
        );

        $errorLines = array_map(
            static fn (Error $error): int => $error->getLine() ?? 0,
            $labIDErrors,
        );

        // Lines 44-45: Array keys 'labID', 'LabID' - should NOT be detected (identifier-like)
        self::assertNotContains(44, $errorLines, 'Should not report array key labID');
        self::assertNotContains(45, $errorLines, 'Should not report array key LabID');

        // Line 52: Single identifier string 'labID' - should NOT be detected
        self::assertNotContains(52, $errorLines, 'Should not report identifier string labID');
    }

    public function testIgnoresSqlQueryWithAnnotation(): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');

        $labIDErrors = array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), 'should use "Lab ID"'),
        );

        $errorLines = array_map(
            static fn (Error $error): int => $error->getLine() ?? 0,
            $labIDErrors,
        );

        // Lines 57-64: SQL query WITH @lang annotation - should NOT be detected
        $sqlAnnotatedErrors = array_filter(
            $errorLines,
            static fn (int $line): bool => $line >= 57 && $line <= 64,
        );

        self::assertEmpty($sqlAnnotatedErrors, 'Should ignore SQL query with @lang annotation');
    }

    public function testDetectsSqlQueryWithoutAnnotation(): void
    {
        $errors = $this->runAnalyse(__DIR__ . '/data/lab-id-capitalization.php');

        $labIDErrors = array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), 'should use "Lab ID"'),
        );

        $errorLines = array_map(
            static fn (Error $error): int => $error->getLine() ?? 0,
            $labIDErrors,
        );

        // Lines 66-72: SQL query WITHOUT @lang annotation - should be detected
        self::assertTrue(
            count(array_filter($errorLines, static fn (int $line): bool => $line >= 66 && $line <= 72)) > 0,
            'Should detect labID in SQL query without @lang annotation',
        );
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

    /** @return array<string> */
    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/phpstan-test.neon',
        ];
    }
}

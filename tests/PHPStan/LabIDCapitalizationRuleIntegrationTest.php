<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use PHPStan\Analyser\Analyser;
use PHPStan\Analyser\Error;
use PHPStan\Testing\PHPStanTestCase;

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

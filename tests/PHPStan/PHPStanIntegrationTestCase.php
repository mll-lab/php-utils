<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use PHPStan\Analyser\Analyser;
use PHPStan\Analyser\Error;
use PHPStan\Testing\PHPStanTestCase;

/**
 * Base class for PHPStan rule integration tests.
 *
 * Provides common functionality for analyzing files and asserting expected errors.
 */
abstract class PHPStanIntegrationTestCase extends PHPStanTestCase
{
    /** @return array<Error> */
    protected function analyseFile(string $file): array
    {
        $file = self::getFileHelper()->normalizePath($file);

        /** @var Analyser $analyser */
        $analyser = self::getContainer()->getByType(Analyser::class);

        $result = $analyser->analyse([$file]);

        return $result->getErrors();
    }

    /**
     * Filter errors by message pattern.
     *
     * @param array<Error> $errors
     *
     * @return array<Error>
     */
    protected function filterErrors(array $errors, string $messagePattern): array
    {
        return array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), $messagePattern),
        );
    }

    /**
     * Assert that actual errors match expected errors by line number and message.
     *
     * @param array<int, array<int, string>> $expectedErrors Map of line number to expected messages
     * @param array<Error> $actualErrors
     */
    protected function assertExpectedErrors(array $expectedErrors, array $actualErrors): void
    {
        // Check all actual errors are expected
        foreach ($actualErrors as $error) {
            $errorLine = $error->getLine() ?? 0;
            $errorMessage = $error->getMessage();

            self::assertArrayHasKey($errorLine, $expectedErrors, "Unexpected error at line {$errorLine}: {$errorMessage}");
            self::assertContains($errorMessage, $expectedErrors[$errorLine]);
        }

        // Check all expected errors were reported
        $actualLines = array_map(
            static fn (Error $error): int => $error->getLine() ?? 0,
            $actualErrors,
        );
        foreach (array_keys($expectedErrors) as $expectedLine) {
            self::assertContains($expectedLine, $actualLines, "Expected error at line {$expectedLine} was not reported");
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

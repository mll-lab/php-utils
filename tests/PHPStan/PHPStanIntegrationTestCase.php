<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use PHPStan\Analyser\Analyser;
use PHPStan\Analyser\Error;
use PHPStan\Testing\PHPStanTestCase;

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
     * @param array<int, array<int, string>> $expectedErrors
     * @param array<Error> $actualErrors
     */
    protected function assertExpectedErrors(array $expectedErrors, array $actualErrors): void
    {
        foreach ($actualErrors as $error) {
            $errorLine = $error->getLine() ?? 0;
            $errorMessage = $error->getMessage();

            self::assertArrayHasKey($errorLine, $expectedErrors, "Unexpected error at line {$errorLine}: {$errorMessage}");
            self::assertContains($errorMessage, $expectedErrors[$errorLine]);
        }

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

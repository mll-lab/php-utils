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
    /** @return iterable<string, array{0: string, 1: array<int, array<int, string>>}> */
    public static function dataIntegrationTests(): iterable
    {
        self::getContainer();

        yield 'detects wrong capitalization' => [
            __DIR__ . '/data/lab-id-capitalization.php',
            [
                // Line 9: 'The LabID is wrong' - wrong capitalization
                9 => ['String "The LabID is wrong" should use "Lab ID" instead of "LabID", change it to "The Lab ID is wrong".'],
                // Line 30: GraphQL query WITHOUT @lang annotation - wrong capitalization (multiline string starts here)
                30 => ['String "
            {
                patient {
                    labID
                }
            }
        " should use "Lab ID" instead of "labID", change it to "
            {
                patient {
                    Lab ID
                }
            }
        ".'],
                // Line 68: SQL query WITHOUT @lang annotation - wrong capitalization (multiline string starts here)
                68 => ['String "
            SELECT exam_no AS labID
            FROM examinations
        " should use "Lab ID" instead of "labID", change it to "
            SELECT exam_no AS Lab ID
            FROM examinations
        ".'],
            ],
        ];
    }

    /**
     * @param array<int, array<int, string>> $expectedErrors
     *
     * @dataProvider dataIntegrationTests
     */
    #[DataProvider('dataIntegrationTests')]
    public function testIntegration(string $file, array $expectedErrors): void
    {
        $errors = $this->runAnalyse($file);

        $labIDErrors = array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), 'should use "Lab ID"'),
        );

        if ($expectedErrors === []) {
            self::assertEmpty($labIDErrors, 'Should not report errors for correct capitalization');
        } else {
            self::assertNotEmpty($labIDErrors, 'Should detect wrong Lab ID capitalization');
            $this->assertExpectedErrors($expectedErrors, $labIDErrors);
        }
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
     * @param array<int, array<int, string>> $expectedErrors
     * @param array<Error> $actualErrors
     */
    private function assertExpectedErrors(array $expectedErrors, array $actualErrors): void
    {
        foreach ($actualErrors as $error) {
            $errorLine = $error->getLine() ?? 0;
            $errorMessage = $error->getMessage();

            self::assertArrayHasKey($errorLine, $expectedErrors, "Unexpected error at line {$errorLine}: {$errorMessage}");
            self::assertContains($errorMessage, $expectedErrors[$errorLine]);
        }

        // Verify we got all expected errors
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

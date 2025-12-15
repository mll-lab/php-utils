<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use PHPStan\Analyser\Analyser;
use PHPStan\Analyser\Error;
use PHPStan\Testing\PHPStanTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class CapitalizationOfIDRuleIntegrationTest extends PHPStanTestCase
{
    /** @return iterable<array{0: string, 1: array<int, array<int, string>>}> */
    public static function dataIntegrationTests(): iterable
    {
        self::getContainer();

        yield [__DIR__ . '/data/wrong-capitalization.php', [
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

        yield [__DIR__ . '/data/correct-capitalization.php', []];
    }

    /** @param array<int, array<int, string>> $expectedErrors */
    #[DataProvider('dataIntegrationTests')]
    public function testIntegration(string $file, array $expectedErrors): void
    {
        $errors = $this->runAnalyse($file);

        $ourErrors = array_filter(
            $errors,
            static function (Error $error): bool {
                $message = $error->getMessage();

                return str_contains($message, 'should use "ID" instead of "Id"');
            }
        );

        if ($expectedErrors === []) {
            self::assertEmpty($ourErrors, 'Should not report errors for correct capitalization');
        } else {
            self::assertNotEmpty($ourErrors, 'Should detect wrong capitalization');
            $this->assertSameErrorMessages($expectedErrors, $ourErrors);
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

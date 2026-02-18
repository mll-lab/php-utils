<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use PHPStan\Analyser\Analyser;
use PHPStan\Analyser\Error;
use PHPStan\Testing\PHPStanTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class OneThingPerLineRuleTest extends PHPStanTestCase
{
    private const ERROR_MESSAGE = 'Method chain calls must each be on their own line.';

    /** @return iterable<array{0: string, 1: array<int, array<int, string>>}> */
    public static function dataIntegrationTests(): iterable
    {
        self::getContainer();

        yield [__DIR__ . '/data/method-chain-violations.php', [
            26 => [self::ERROR_MESSAGE],
            31 => [self::ERROR_MESSAGE, self::ERROR_MESSAGE],
            36 => [self::ERROR_MESSAGE],
            41 => [self::ERROR_MESSAGE],
            46 => [self::ERROR_MESSAGE],
            53 => [self::ERROR_MESSAGE],
            60 => [self::ERROR_MESSAGE],
        ]];

        yield [__DIR__ . '/data/method-chain-correct.php', []];
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

        $ourErrors = array_filter(
            $errors,
            static fn (Error $error): bool => str_contains($error->getMessage(), self::ERROR_MESSAGE),
        );

        if ($expectedErrors === []) {
            self::assertEmpty($ourErrors, 'Should not report errors for correct code');
        } else {
            self::assertNotEmpty($ourErrors, 'Should detect method chain violations');
            $this->assertSameErrorMessages($expectedErrors, $ourErrors);
        }
    }

    /** @return array<Error> */
    private function runAnalyse(string $file): array
    {
        $file = self::getFileHelper()->normalizePath($file);

        /** @var Analyser $analyser */
        $analyser = self::getContainer()->getByType(Analyser::class);

        return $analyser->analyse([$file])->getErrors();
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
            __DIR__ . '/phpstan-one-thing-per-line-test.neon',
        ];
    }
}

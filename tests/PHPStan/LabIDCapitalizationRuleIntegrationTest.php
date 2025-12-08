<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan;

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * @requires PHP >= 8.3
 */
final class LabIDCapitalizationRuleIntegrationTest extends PHPStanIntegrationTestCase
{
    private const ERROR_PATTERN = 'should use "Lab ID"';

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
        $errors = $this->analyseFile($file);
        $filteredErrors = $this->filterErrors($errors, self::ERROR_PATTERN);

        if ($expectedErrors === []) {
            self::assertEmpty($filteredErrors, 'Should not report errors for correct capitalization');
        } else {
            self::assertNotEmpty($filteredErrors, 'Should detect wrong Lab ID capitalization');
            $this->assertExpectedErrors($expectedErrors, $filteredErrors);
        }
    }
}

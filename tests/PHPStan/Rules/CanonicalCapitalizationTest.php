<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\Rules;

use MLL\Utils\PHPStan\Rules\CanonicalCapitalization;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CanonicalCapitalizationTest extends TestCase
{
    public const EXPECTED_LAB_ID_IS_INCORRECT = 'The Lab ID is incorrect';

    /**
     * @dataProvider wrongCapitalizationProvider
     *
     * @param array{string, string, string} $data
     */
    #[DataProvider('wrongCapitalizationProvider')]
    public function testFindWrongCapitalization(string $nodeName, array $data): void
    {
        [$correct, $incorrect, $correctedNodeName] = $data;

        $capitalization = CanonicalCapitalization::findWrongCapitalization($nodeName);

        self::assertNotNull($capitalization);
        self::assertSame($correct, $capitalization[0]);
        self::assertSame($incorrect, $capitalization[1]);
        self::assertSame($correctedNodeName, CanonicalCapitalization::fixIDCapitalization($nodeName, $correct, $incorrect));
    }

    /** @return iterable<array{string, array{string, string}}> */
    public static function wrongCapitalizationProvider(): iterable
    {
        yield 'Should correct capitalization for "LabID "' => ['The LabID is incorrect', ['Lab ID', 'LabID ', self::EXPECTED_LAB_ID_IS_INCORRECT]];
        yield 'Should correct capitalization for "Lab-ID"' => ['The Lab-ID is incorrect', ['Lab ID', 'Lab-ID', self::EXPECTED_LAB_ID_IS_INCORRECT]];
        yield 'Should correct capitalization for "lab id"' => ['The lab id is incorrect', ['Lab ID', 'lab id', self::EXPECTED_LAB_ID_IS_INCORRECT]];
        yield 'Should correct capitalization for "labID"' => ['The labID is incorrect', ['Lab ID', 'labID', self::EXPECTED_LAB_ID_IS_INCORRECT]];
        yield 'Should correct capitalization for " LabID"' => ['The LabID', ['Lab ID', ' LabID', 'The Lab ID']];
        yield 'Should correct capitalization for "LABID"' => ['The LABID is incorrect', ['Lab ID', 'LABID', self::EXPECTED_LAB_ID_IS_INCORRECT]];
        yield 'Should correct capitalization for "Labid"' => ['The Labid is incorrect', ['Lab ID', 'Labid', self::EXPECTED_LAB_ID_IS_INCORRECT]];
        yield 'Should correct capitalization for "lab-Id"' => ['The lab-Id is incorrect', ['Lab ID', 'lab-Id', self::EXPECTED_LAB_ID_IS_INCORRECT]];
        yield 'Should correct capitalization for "Lab Id"' => ['The Lab Id is incorrect', ['Lab ID', 'Lab Id', self::EXPECTED_LAB_ID_IS_INCORRECT]];
    }

    /** @dataProvider rightCapitalizationProvider */
    #[DataProvider('rightCapitalizationProvider')]
    public function testFindWrongCapitalizationFalse(string $nodeName): void
    {
        self::assertNull(CanonicalCapitalization::findWrongCapitalization($nodeName));
    }

    /** @return iterable<array<string>> */
    public static function rightCapitalizationProvider(): iterable
    {
        yield 'Should not be fixed because it might be in a non-space case written' => ['TheLabIDIsIncorrect'];
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\Rules\CapitalizationOfIDRule;

use PHPUnit\Framework\TestCase;

use function Safe\file_put_contents;
use function Safe\tempnam;
use function Safe\unlink;

/**
 * Integration tests for CapitalizationOfIDRule.
 *
 * These tests verify that the rule correctly identifies violations
 * in real PHP code by running PHPStan against fixture files.
 */
final class CapitalizationOfIDRuleIntegrationTest extends TestCase
{
    private const FIXTURES_DIR = __DIR__ . '/Fixtures';

    public function testDetectsWrongCapitalizationInMethods(): void
    {
        $output = $this->runPHPStanOnFixture('WrongCapitalization.php');

        self::assertStringContainsString('getLabId', $output, 'Should detect wrong method name');
        self::assertStringContainsString('should use "ID" instead of "Id"', $output);
    }

    public function testDetectsWrongCapitalizationInParameters(): void
    {
        $output = $this->runPHPStanOnFixture('WrongCapitalization.php');

        self::assertStringContainsString('labId', $output, 'Should detect wrong parameter name');
    }

    public function testDetectsWrongCapitalizationInVariables(): void
    {
        $output = $this->runPHPStanOnFixture('WrongCapitalization.php');

        self::assertStringContainsString('sampleId', $output, 'Should detect wrong variable name');
    }

    public function testAllowsCorrectCapitalization(): void
    {
        $output = $this->runPHPStanOnFixture('CorrectCapitalization.php');

        // Should have no errors from our rule (may have other errors, filter by identifier)
        self::assertStringNotContainsString('mll.capitalizationOfID', $output, 'Should not report errors for correct capitalization');
    }

    public function testAllowsFalsePositives(): void
    {
        $output = $this->runPHPStanOnFixture('CorrectCapitalization.php');

        self::assertStringNotContainsString('getIdentifier', $output, 'Should not flag "Identifier"');
        self::assertStringNotContainsString('isIdentical', $output, 'Should not flag "Identical"');
    }

    private function runPHPStanOnFixture(string $fixtureFile): string
    {
        $fixturePath = self::FIXTURES_DIR . '/' . $fixtureFile;
        $projectRoot = dirname(__DIR__, 4);

        // Create a temporary neon config that enables the rule
        $tempConfig = tempnam(sys_get_temp_dir(), 'phpstan_test_') . '.neon';
        $configContent = <<<NEON
includes:
    - {$projectRoot}/extension.neon

parameters:
    customRulesetUsed: true
    mllCapitalizationOfID:
        enabled: true
NEON;
        file_put_contents($tempConfig, $configContent);

        $command = escapeshellarg($projectRoot) . '/vendor/bin/phpstan analyse'
            . ' --configuration=' . escapeshellarg($tempConfig)
            . ' --error-format=raw --no-progress'
            . ' ' . escapeshellarg($fixturePath)
            . ' 2>&1';

        // @phpstan-ignore-next-line We handle null/false case below
        $output = shell_exec($command);

        unlink($tempConfig);

        return is_string($output) ? $output : '';
    }
}

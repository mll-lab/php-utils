<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet;

use PHPUnit\Framework\TestCase;

class SettingsSectionTest extends TestCase
{
    public function testSettingsSectionToStringReturnsCorrectFormat(): void
    {
        $settingsSection = new \MLL\Utils\IlluminaSampleSheet\V1\SettingsSection('AGATCG', 'TCG');

        self::assertSame("[Settings]\nAdapter,AGATCG\nAdapterRead2,TCG", $settingsSection->convertSectionToString());
    }
}

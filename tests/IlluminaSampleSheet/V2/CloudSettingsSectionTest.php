<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\V2\CloudSettingsSection;
use PHPUnit\Framework\TestCase;

class CloudSettingsSectionTest extends TestCase
{
    public function testCloudSettingsSectionToStringReturnsCorrectFormat(): void
    {
        $cloudSettingsSection = new CloudSettingsSection('1.0', 'Workflow1', 'Pipeline1');

        $expectedString = "[Cloud_Settings]\nGeneratedVersion,1.0\nCloud_Workflow,Workflow1\nBCLConvert_Pipeline,Pipeline1\n";

        self::assertSame($expectedString, $cloudSettingsSection->convertSectionToString());
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet;

use MLL\Utils\IlluminaSampleSheet\V2\CloudDataSection;
use PHPUnit\Framework\TestCase;

class CloudDataSectionTest extends TestCase
{
    public function testCloudDataSectionToStringReturnsCorrectFormat(): void
    {
        $cloudDataSection = new CloudDataSection();
        $cloudDataSection->addSample('sampleId1', 'projectName1', 'libraryName1', 'libraryPrepKitName1', 'indexAdapterKitName1');
        $cloudDataSection->addSample('sampleId2', 'projectName2', 'libraryName2', 'libraryPrepKitName2', 'indexAdapterKitName2');

        $expectedString = "[Cloud_Data]\nSample_ID,ProjectName,LibraryName,LibraryPrepKitName,IndexAdapterKitName\nsampleId1,projectName1,libraryName1,libraryPrepKitName1,indexAdapterKitName1\nsampleId2,projectName2,libraryName2,libraryPrepKitName2,indexAdapterKitName2\n";

        self::assertSame($expectedString, $cloudDataSection->toString());
    }
}

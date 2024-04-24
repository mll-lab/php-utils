<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\V2\CloudDataSample;
use PHPUnit\Framework\TestCase;

class CloudDataSampleTest extends TestCase
{
    public function testConstructorAssignsValuesCorrectly(): void
    {
        $cloudDataSample = new CloudDataSample(
            'sampleId2',
            'projectName2',
            'libraryName2',
            'libraryPrepKitName2',
            'indexAdapterKitName2'
        );

        self::assertSame('sampleId2', $cloudDataSample->sampleId);
        self::assertSame('projectName2', $cloudDataSample->projectName);
        self::assertSame('libraryName2', $cloudDataSample->libraryName);
        self::assertSame('libraryPrepKitName2', $cloudDataSample->libraryPrepKitName);
        self::assertSame('indexAdapterKitName2', $cloudDataSample->indexAdapterKitName);
    }

    public function testToArrayReturnsCorrectStructure(): void
    {
        $cloudDataSample = new CloudDataSample(
            'sampleId1',
            'projectName1',
            'libraryName1',
            'libraryPrepKitName1',
            'indexAdapterKitName1'
        );

        $expectedArray = [
            'Sample_ID' => 'sampleId1',
            'ProjectName' => 'projectName1',
            'LibraryName' => 'libraryName1',
            'LibraryPrepKitName' => 'libraryPrepKitName1',
            'IndexAdapterKitName' => 'indexAdapterKitName1',
        ];

        self::assertSame($expectedArray, $cloudDataSample->toArray());
    }
}

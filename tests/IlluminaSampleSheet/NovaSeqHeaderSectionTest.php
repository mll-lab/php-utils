<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet;

use PHPUnit\Framework\TestCase;

class NovaSeqHeaderSectionTest extends TestCase
{
    public function testHeaderSectionToStringReturnsCorrectFormat(): void
    {
        $headerSection = new \MLL\Utils\IlluminaSampleSheet\V1\NovaSeqHeaderSection(
            '4',
            'Investigator1',
            'Experiment1',
            '2022-01-01',
            'Workflow1',
            'Application1',
            'Assay1',
            'Description1',
            'Chemistry1'
        );

        $expectedString = "[Header]\nIEMFileVersion,4\nInvestigator Name,Investigator1\nExperiment Name,Experiment1\nDate,2022-01-01\nWorkflow,Workflow1\nApplication,Application1\nAssay,Assay1\nDescription,Description1\nChemistry,Chemistry1";

        self::assertSame($expectedString, $headerSection->convertSectionToString());
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\Tests\Unit\QxManager;

use MLL\Utils\QxManager\FilledRow;
use PHPUnit\Framework\TestCase;

class FilledRowTest extends TestCase
{
    public function testToString(): void
    {
        $filledRow = new FilledRow(
            'Sample 1',
            'Sample 2',
            null,
            null,
            'Sample Type',
            'Experiment Type',
            'Supermix Name',
            'Assay Type',
            'Target Type',
            'Plot',
            'Target Name',
            'Signal Ch1',
            'Signal Ch2',
            1000,
            'Well Notes',
            'RDQ Conversion Factor'
        );

        $expectedString = 'Yes,Experiment Type,Sample 1,Sample 2,,,Sample Type,Supermix Name,Assay Type,Target Name,Target Type,Signal Ch1,Signal Ch2,1000,Well Notes,Plot,RDQ Conversion Factor';

        self::assertEquals($expectedString, $filledRow->toString());
    }

    public function testToStringWithNullValues(): void
    {
        $filledRow = new FilledRow(
            'Sample 1',
            null,
            null,
            null,
            'Sample Type',
            'Experiment Type',
            'Supermix Name',
            'Assay Type',
            'Target Type',
            'Plot',
            'Target Name',
            'Signal Ch1',
            'Signal Ch2'
        );

        $expectedString = 'Yes,Experiment Type,Sample 1,,,,Sample Type,Supermix Name,Assay Type,Target Name,Target Type,Signal Ch1,Signal Ch2,,,Plot,';

        self::assertEquals($expectedString, $filledRow->toString());
    }
}

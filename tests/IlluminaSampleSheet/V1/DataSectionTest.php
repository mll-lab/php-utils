<?php declare(strict_types=1);

namespace MLL\Utils\Tests\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\V1\DataSection;
use MLL\Utils\IlluminaSampleSheet\V1\DualIndex;
use MLL\Utils\IlluminaSampleSheet\V1\RowForDualIndexWithLane;
use MLL\Utils\IlluminaSampleSheet\V1\RowForDualIndexWithoutLane;
use PHPUnit\Framework\TestCase;

final class DataSectionTest extends TestCase
{
    public function testDataSectionWithDualIndexWithLaneWorksNotWhenRowWithWrongTypeIsAdded(): void
    {
        $sampleSheetDataSection = new DataSection(RowForDualIndexWithLane::class);

        $dualIndex = new DualIndex('UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG');
        $sampleSheetDataSection->addRow(
            // @phpstan-ignore-next-line expecting a type error due to mismatching row types
            new RowForDualIndexWithoutLane(
                $dualIndex,
                '1',
                'Sample-001-M001',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );

        $this->expectNotToPerformAssertions();
    }

    public function testDataSectionWithDualIndexWithoutLaneWorksNotWhenRowWithWrongTypeIsAdded(): void
    {
        $sampleSheetDataSection = new DataSection(RowForDualIndexWithoutLane::class);

        $dualIndex = new DualIndex('UDP0090', 'TCAGGCTT', 'UDP0090', 'ATCATGCG');
        $sampleSheetDataSection->addRow(
            // @phpstan-ignore-next-line expecting a type error due to mismatching row types
            new RowForDualIndexWithLane(
                $dualIndex,
                1,
                '1',
                'Sample-001-M001',
                'RunXXXX-PLATE',
                '',
                'RunXXXX-PROJECT',
                'description'
            )
        );

        $this->expectNotToPerformAssertions();
    }
}

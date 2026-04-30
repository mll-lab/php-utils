<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

use MLL\Utils\SafeCast;

class RunResult
{
    public ClusterStatistic $clusterStatistic;

    public SequencingQualityControl $sequencingQualityControl;

    public function __construct(ClusterStatistic $clusterStatistic, SequencingQualityControl $sequencingQualityControl)
    {
        $this->clusterStatistic = $clusterStatistic;
        $this->sequencingQualityControl = $sequencingQualityControl;
    }

    /** @param array<string, string> $nonIndexedRow */
    public static function fromLaneResults(LaneResult $read1, LaneResult $read2, array $nonIndexedRow): self
    {
        $aggregated = LaneResult::aggregate($read1, $read2);

        $q30 = SafeCast::toFloat($nonIndexedRow['%>=Q30']);

        $alignedValue = SafeCast::toFloat($nonIndexedRow['Aligned']);
        $alignedDeviation = ($read1->sequencingQualityControl->aligned->deviation + $read2->sequencingQualityControl->aligned->deviation) / 2;
        $aligned = new DeviationValue($alignedValue, $alignedDeviation);

        $sequencingQualityControl = new SequencingQualityControl(
            $q30,
            $aggregated->sequencingQualityControl->phasing,
            $aggregated->sequencingQualityControl->prephasing,
            $aligned,
            $aggregated->sequencingQualityControl->error
        );

        return new self($aggregated->clusterStatistic, $sequencingQualityControl);
    }
}

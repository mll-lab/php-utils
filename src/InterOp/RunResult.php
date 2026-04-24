<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

class RunResult
{
    public ClusterStatistic $clusterStatistic;

    public SequencingQualityControl $sequencingQualityControl;

    public function __construct(ClusterStatistic $clusterStatistic, SequencingQualityControl $sequencingQualityControl)
    {
        $this->clusterStatistic = $clusterStatistic;
        $this->sequencingQualityControl = $sequencingQualityControl;
    }

    public static function fromLaneResults(LaneResult $read1, LaneResult $read2): self
    {
        $aggregated = LaneResult::aggregate($read1, $read2);

        return new self($aggregated->clusterStatistic, $aggregated->sequencingQualityControl);
    }
}

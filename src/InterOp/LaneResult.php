<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

class LaneResult
{
    /** @var ClusterStatistic */
    public $clusterStatistic;

    /** @var SequencingQualityControl */
    public $sequencingQualityControl;

    /** @var int Intensity at cycle 1. */
    public $intensityCycle;

    /** @var int Yield in bases (JSON float in gigabases * 1_000_000). */
    public $yield;

    public function __construct(ClusterStatistic $clusterStatistic, SequencingQualityControl $sequencingQualityControl, int $intensityCycle, int $yield)
    {
        $this->clusterStatistic = $clusterStatistic;
        $this->sequencingQualityControl = $sequencingQualityControl;
        $this->intensityCycle = $intensityCycle;
        $this->yield = $yield;
    }

    /**
     * Builds a LaneResult from the first row (Surface "-") of a reads entry.
     *
     * @param array<string, string> $row single lane row from interop reads data
     */
    public static function fromInterOpRow(array $row): self
    {
        $density = DeviationValue::parse($row['Density']);
        assert($density instanceof DeviationValue, "Expected parseable Density, got: {$row['Density']}.");

        $clusterPF = DeviationValue::parse($row['Cluster PF']);
        assert($clusterPF instanceof DeviationValue, "Expected parseable Cluster PF, got: {$row['Cluster PF']}.");

        $aligned = DeviationValue::parse($row['Aligned']);
        assert($aligned instanceof DeviationValue, "Expected parseable Aligned, got: {$row['Aligned']}.");

        $error = DeviationValue::parse($row['Error']);
        assert($error instanceof DeviationValue, "Expected parseable Error, got: {$row['Error']}.");

        $intensityCycle = DeviationValue::parse($row['Intensity C1']);
        assert($intensityCycle instanceof DeviationValue, "Expected parseable Intensity C1, got: {$row['Intensity C1']}.");

        $phasingParts = explode(' / ', $row['Legacy Phasing/Prephasing Rate']);
        assert(count($phasingParts) === 2, "Expected 'phasing / prephasing' format, got: {$row['Legacy Phasing/Prephasing Rate']}.");
        assert($phasingParts[0] !== 'nan', 'Unexpected nan phasing rate for data read.');

        $clusterStatistic = new ClusterStatistic(
            $density,
            $clusterPF,
            (float) $row['Reads'],
            (float) $row['Reads PF']
        );

        $sequencingQualityControl = new SequencingQualityControl(
            (float) $row['%>=Q30'],
            (float) $phasingParts[0],
            (float) $phasingParts[1],
            $aligned,
            $error
        );

        return new self(
            $clusterStatistic,
            $sequencingQualityControl,
            (int) $intensityCycle->value,
            (int) ((float) $row['Yield'] * 1000000)
        );
    }

    public static function aggregate(self $a, self $b): self
    {
        $density = new DeviationValue(
            ($a->clusterStatistic->density->value + $b->clusterStatistic->density->value) / 2,
            ($a->clusterStatistic->density->deviation + $b->clusterStatistic->density->deviation) / 2
        );

        $clusterPF = new DeviationValue(
            ($a->clusterStatistic->clusterPF->value + $b->clusterStatistic->clusterPF->value) / 2,
            ($a->clusterStatistic->clusterPF->deviation + $b->clusterStatistic->clusterPF->deviation) / 2
        );

        $clusterStatistic = new ClusterStatistic(
            $density,
            $clusterPF,
            $a->clusterStatistic->clusterCount + $b->clusterStatistic->clusterCount,
            $a->clusterStatistic->clusterCountPF + $b->clusterStatistic->clusterCountPF
        );

        $aligned = new DeviationValue(
            ($a->sequencingQualityControl->aligned->value + $b->sequencingQualityControl->aligned->value) / 2,
            ($a->sequencingQualityControl->aligned->deviation + $b->sequencingQualityControl->aligned->deviation) / 2
        );

        $error = new DeviationValue(
            ($a->sequencingQualityControl->error->value + $b->sequencingQualityControl->error->value) / 2,
            ($a->sequencingQualityControl->error->deviation + $b->sequencingQualityControl->error->deviation) / 2
        );

        $sequencingQualityControl = new SequencingQualityControl(
            ($a->sequencingQualityControl->q30 + $b->sequencingQualityControl->q30) / 2,
            ($a->sequencingQualityControl->phasing + $b->sequencingQualityControl->phasing) / 2,
            ($a->sequencingQualityControl->prephasing + $b->sequencingQualityControl->prephasing) / 2,
            $aligned,
            $error
        );

        return new self(
            $clusterStatistic,
            $sequencingQualityControl,
            (int) (($a->intensityCycle + $b->intensityCycle) / 2),
            $a->yield + $b->yield
        );
    }
}

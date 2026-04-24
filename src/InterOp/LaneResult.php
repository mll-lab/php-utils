<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

use MLL\Utils\SafeCast;

class LaneResult
{
    public ClusterStatistic $clusterStatistic;

    public SequencingQualityControl $sequencingQualityControl;

    public int $intensityCycle;

    /** Yield in kilobases (JSON float in gigabases * 1_000_000). */
    public int $yield;

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

        $clusterPassingFilter = DeviationValue::parse($row['Cluster PF']);
        assert($clusterPassingFilter instanceof DeviationValue, "Expected parseable Cluster PF, got: {$row['Cluster PF']}.");

        $aligned = DeviationValue::parse($row['Aligned']);
        assert($aligned instanceof DeviationValue, "Expected parseable Aligned, got: {$row['Aligned']}.");

        $error = DeviationValue::parse($row['Error']);
        assert($error instanceof DeviationValue, "Expected parseable Error, got: {$row['Error']}.");

        $intensityCycle = DeviationValue::parse($row['Intensity C1']);
        assert($intensityCycle instanceof DeviationValue, "Expected parseable Intensity C1, got: {$row['Intensity C1']}.");

        $phasingParts = explode(' / ', $row['Legacy Phasing/Prephasing Rate']);
        assert(count($phasingParts) === 2, "Expected 'phasing / prephasing' format, got: {$row['Legacy Phasing/Prephasing Rate']}.");
        assert($phasingParts[0] !== 'nan', 'Unexpected nan phasing rate for data read.');
        assert($phasingParts[1] !== 'nan', 'Unexpected nan prephasing rate for data read.');

        $clusterStatistic = new ClusterStatistic(
            $density,
            $clusterPassingFilter,
            SafeCast::toFloat($row['Reads']),
            SafeCast::toFloat($row['Reads PF'])
        );

        $sequencingQualityControl = new SequencingQualityControl(
            SafeCast::toFloat($row['%>=Q30']),
            SafeCast::toFloat($phasingParts[0]),
            SafeCast::toFloat($phasingParts[1]),
            $aligned,
            $error
        );

        return new self(
            $clusterStatistic,
            $sequencingQualityControl,
            SafeCast::toInt($intensityCycle->value),
            SafeCast::toInt(SafeCast::toFloat($row['Yield']) * 1000000)
        );
    }

    public static function aggregate(self $a, self $b): self
    {
        $clusterStatistic = new ClusterStatistic(
            DeviationValue::average($a->clusterStatistic->density, $b->clusterStatistic->density),
            DeviationValue::average($a->clusterStatistic->clusterPassingFilter, $b->clusterStatistic->clusterPassingFilter),
            $a->clusterStatistic->clusterCount + $b->clusterStatistic->clusterCount,
            $a->clusterStatistic->clusterCountPassingFilter + $b->clusterStatistic->clusterCountPassingFilter
        );

        $sequencingQualityControl = new SequencingQualityControl(
            ($a->sequencingQualityControl->q30 + $b->sequencingQualityControl->q30) / 2,
            ($a->sequencingQualityControl->phasing + $b->sequencingQualityControl->phasing) / 2,
            ($a->sequencingQualityControl->prephasing + $b->sequencingQualityControl->prephasing) / 2,
            DeviationValue::average($a->sequencingQualityControl->aligned, $b->sequencingQualityControl->aligned),
            DeviationValue::average($a->sequencingQualityControl->error, $b->sequencingQualityControl->error)
        );

        return new self(
            $clusterStatistic,
            $sequencingQualityControl,
            intdiv($a->intensityCycle + $b->intensityCycle, 2),
            $a->yield + $b->yield
        );
    }
}

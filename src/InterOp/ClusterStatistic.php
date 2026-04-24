<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

class ClusterStatistic
{
    public DeviationValue $density;

    public DeviationValue $clusterPassingFilter;

    public float $clusterCount;

    public float $clusterCountPassingFilter;

    public function __construct(DeviationValue $density, DeviationValue $clusterPassingFilter, float $clusterCount, float $clusterCountPassingFilter)
    {
        $this->density = $density;
        $this->clusterPassingFilter = $clusterPassingFilter;
        $this->clusterCount = $clusterCount;
        $this->clusterCountPassingFilter = $clusterCountPassingFilter;
    }
}

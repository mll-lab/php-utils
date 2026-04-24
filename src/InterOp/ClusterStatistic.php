<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

class ClusterStatistic
{
    public DeviationValue $density;

    public DeviationValue $clusterPF;

    public float $clusterCount;

    public float $clusterCountPF;

    public function __construct(DeviationValue $density, DeviationValue $clusterPF, float $clusterCount, float $clusterCountPF)
    {
        $this->density = $density;
        $this->clusterPF = $clusterPF;
        $this->clusterCount = $clusterCount;
        $this->clusterCountPF = $clusterCountPF;
    }
}

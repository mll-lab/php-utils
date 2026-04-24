<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

class ClusterStatistic
{
    /** @var DeviationValue Cluster density (K/mm²). */
    public $density;

    /** @var DeviationValue Percentage of clusters passing filter. */
    public $clusterPF;

    /** @var float Total cluster count (millions). */
    public $clusterCount;

    /** @var float Clusters passing filter (millions). */
    public $clusterCountPF;

    public function __construct(DeviationValue $density, DeviationValue $clusterPF, float $clusterCount, float $clusterCountPF)
    {
        $this->density = $density;
        $this->clusterPF = $clusterPF;
        $this->clusterCount = $clusterCount;
        $this->clusterCountPF = $clusterCountPF;
    }
}

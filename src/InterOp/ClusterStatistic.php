<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

class ClusterStatistic
{
    public DeviationValue $density;

    public DeviationValue $clusterPassingFilter;

    public float $clusterCountMillions;

    public float $clusterCountPassingFilterMillions;

    public function __construct(DeviationValue $density, DeviationValue $clusterPassingFilter, float $clusterCountMillions, float $clusterCountPassingFilterMillions)
    {
        $this->density = $density;
        $this->clusterPassingFilter = $clusterPassingFilter;
        $this->clusterCountMillions = $clusterCountMillions;
        $this->clusterCountPassingFilterMillions = $clusterCountPassingFilterMillions;
    }
}

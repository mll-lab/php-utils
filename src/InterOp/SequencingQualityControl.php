<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

class SequencingQualityControl
{
    /** @var float Percentage of bases with quality score >= Q30. */
    public $q30;

    /** @var float Phasing rate. */
    public $phasing;

    /** @var float Prephasing rate. */
    public $prephasing;

    /** @var DeviationValue Alignment percentage. */
    public $aligned;

    /** @var DeviationValue Error rate. */
    public $error;

    public function __construct(float $q30, float $phasing, float $prephasing, DeviationValue $aligned, DeviationValue $error)
    {
        $this->q30 = $q30;
        $this->phasing = $phasing;
        $this->prephasing = $prephasing;
        $this->aligned = $aligned;
        $this->error = $error;
    }
}

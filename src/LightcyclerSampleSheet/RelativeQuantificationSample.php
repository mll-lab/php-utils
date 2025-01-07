<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class RelativeQuantificationSample
{
    public string $sampleName;

    public string $filterCombination;

    public string $hexColor;

    /** @var Coordinates<CoordinateSystem12x8>|null */
    public ?Coordinates $replicationOf;

    /** @param Coordinates<CoordinateSystem12x8>|null $replicationOf */
    public function __construct(
        string $sampleName,
        string $filterCombination,
        string $hexColor,
        ?Coordinates $replicationOf
    ) {
        $this->sampleName = $sampleName;
        $this->filterCombination = $filterCombination;
        $this->hexColor = $hexColor;
        $this->replicationOf = $replicationOf;
    }
}

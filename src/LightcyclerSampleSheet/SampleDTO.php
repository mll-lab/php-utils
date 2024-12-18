<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class SampleDTO
{
    public string $sampleName;

    /** @var Coordinates<CoordinateSystem12x8>|null */
    public ?Coordinates $replicationOf;

    public string $filterCombination;

    public string $hexColor;

    /** @param Coordinates<CoordinateSystem12x8>|null $replicationOf */
    public function __construct(
        string $labID,
        ?Coordinates $replicationOf,
        string $filterCombination,
        string $hexColor
    ) {
        $this->sampleName = $labID;
        $this->replicationOf = $replicationOf;
        $this->filterCombination = $filterCombination;
        $this->hexColor = $hexColor;
    }
}

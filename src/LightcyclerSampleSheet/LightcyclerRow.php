<?php declare(strict_types=1);

namespace MLL\Utils\LightcyclerSampleSheet;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class LightcyclerRow
{
    /** @var Coordinates<CoordinateSystem12x8> */
    private Coordinates $coordinates;

    private string $sampleName;

    private string $replicationOf;

    private string $filterCombination;

    private RandomHexGenerator $randomHexGenerator;

    /** @param Coordinates<CoordinateSystem12x8> $coordinates */
    public function __construct(
        Coordinates $coordinates,
        string $sampleName,
        string $replicationOf,
        string $filterCombination,
        RandomHexGenerator $randomHexGenerator
    ) {
        $this->coordinates = $coordinates;
        $this->sampleName = $sampleName;
        $this->replicationOf = $replicationOf;
        $this->filterCombination = $filterCombination;
        $this->randomHexGenerator = $randomHexGenerator;
    }

    public function __toString(): string
    {
        $color = "$00{$this->randomHexGenerator->hex6Digits()}";

        return "{$this->coordinates->toString()}\t\"{$this->sampleName}\"\t\"{$this->replicationOf}\"\t{$this->filterCombination}\t{$color}\r\n";
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\TapeStation;

use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\Microplate\CoordinateSystem12x8;

class CompactRegionTableRecord
{
    public string $fileName;

    /** @var Coordinates<CoordinateSystem12x8> */
    public Coordinates $wellID;

    public string $sampleDescription;

    /** Null when the column is absent from the export. */
    public ?int $from;

    public int $to;

    /** Center of mass, not peak maximum. */
    public int $averageSize;

    public float $concentrationNgPerUl;

    public float $regionMolarityNmolPerL;

    public float $percentOfTotal;

    public string $regionComment;

    /** @param Coordinates<CoordinateSystem12x8> $wellID */
    public function __construct(
        string $fileName,
        Coordinates $wellID,
        string $sampleDescription,
        ?int $from,
        int $to,
        int $averageSize,
        float $concentrationNgPerUl,
        float $regionMolarityNmolPerL,
        float $percentOfTotal,
        string $regionComment
    ) {
        $this->fileName = $fileName;
        $this->wellID = $wellID;
        $this->sampleDescription = $sampleDescription;
        $this->from = $from;
        $this->to = $to;
        $this->averageSize = $averageSize;
        $this->concentrationNgPerUl = $concentrationNgPerUl;
        $this->regionMolarityNmolPerL = $regionMolarityNmolPerL;
        $this->percentOfTotal = $percentOfTotal;
        $this->regionComment = $regionComment;
    }
}

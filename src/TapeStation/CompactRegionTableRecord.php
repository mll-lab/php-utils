<?php declare(strict_types=1);

namespace MLL\Utils\TapeStation;

class CompactRegionTableRecord
{
    public string $fileName;

    public string $wellID;

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

    public function __construct(
        string $fileName,
        string $wellID,
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

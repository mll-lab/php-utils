<?php declare(strict_types=1);

namespace MLL\Utils\TapeStation;

class CompactRegionTableRecord
{
    /** @var string */
    public $fileName;

    /** @var string */
    public $wellID;

    /** @var string */
    public $sampleDescription;

    /** @var int|null Region start in bp (DNA) or nt (RNA). Null when the column is absent from the export. */
    public $from;

    /** @var int Region end in bp (DNA) or nt (RNA). */
    public $to;

    /** @var int Average fragment size in bp (DNA) or nt (RNA). Center of mass, not peak maximum. */
    public $averageSize;

    /** @var float */
    public $concentrationNgPerUl;

    /** @var float */
    public $regionMolarityNmolPerL;

    /** @var float */
    public $percentOfTotal;

    /** @var string */
    public $regionComment;

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

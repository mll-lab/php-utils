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

    /** @var int */
    public $fromBp;

    /** @var int */
    public $toBp;

    /** @var int */
    public $averageSizeBp;

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
        int $fromBp,
        int $toBp,
        int $averageSizeBp,
        float $concentrationNgPerUl,
        float $regionMolarityNmolPerL,
        float $percentOfTotal,
        string $regionComment
    ) {
        $this->fileName = $fileName;
        $this->wellID = $wellID;
        $this->sampleDescription = $sampleDescription;
        $this->fromBp = $fromBp;
        $this->toBp = $toBp;
        $this->averageSizeBp = $averageSizeBp;
        $this->concentrationNgPerUl = $concentrationNgPerUl;
        $this->regionMolarityNmolPerL = $regionMolarityNmolPerL;
        $this->percentOfTotal = $percentOfTotal;
        $this->regionComment = $regionComment;
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\TapeStation;

/**
 * A single row from an Agilent TapeStation "Compact Region Table" CSV export.
 *
 * This format is shared across assay types (D1000, HSD1000, RNA, etc.) — the
 * CSV structure is identical, only the units in column headers differ:
 * - D1000 (standard DNA): ng/µl, nmol/l, bp
 * - HSD1000 (high sensitivity DNA): pg/µl, pmol/l, bp
 * - RNA: ng/µl, nmol/l, nt
 *
 * The parser currently only accepts standard assays (ng/µl + nmol/l) and rejects
 * High Sensitivity assays with a clear error. The properties below are therefore
 * unit-agnostic — the caller knows which assay type it is parsing and is
 * responsible for interpreting units correctly.
 *
 * @see CompactRegionTableParser for format detection and validation
 */
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

    /** @var int Average fragment size in bp (DNA) or nt (RNA). */
    public $averageSize;

    /** @var float Concentration from the "Conc." column. Unit depends on assay: ng/µl (standard) or pg/µl (HS). */
    public $concentration;

    /** @var float Region molarity from the "Region Molarity" column. Unit depends on assay: nmol/l (standard) or pmol/l (HS). */
    public $regionMolarity;

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
        float $concentration,
        float $regionMolarity,
        float $percentOfTotal,
        string $regionComment
    ) {
        $this->fileName = $fileName;
        $this->wellID = $wellID;
        $this->sampleDescription = $sampleDescription;
        $this->from = $from;
        $this->to = $to;
        $this->averageSize = $averageSize;
        $this->concentration = $concentration;
        $this->regionMolarity = $regionMolarity;
        $this->percentOfTotal = $percentOfTotal;
        $this->regionComment = $regionComment;
    }
}

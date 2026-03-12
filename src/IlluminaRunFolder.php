<?php declare(strict_types=1);

namespace MLL\Utils;

use Carbon\Carbon;

use function Safe\preg_match;

/**
 * Parses Illumina sequencer run folder names into their components.
 *
 * Run folder format: {Date}_{InstrumentID}_{RunNumber}_{FlowcellSegment}
 * - Date: YYMMDD (MiSeq) or YYYYMMDD (iSeq, NextSeq, NovaSeq)
 * - InstrumentID: Instrument serial number, prefix indicates type (M=MiSeq, NB=NextSeq 500/550, SH=iSeq i100, VH=NextSeq 1000/2000)
 * - RunNumber: Sequential run counter
 * - FlowcellSegment: Flowcell ID with an instrument-specific prefix that gets stripped
 *
 * Flowcell segment formats:
 * - Zero-prefixed (MiSeq): 000000000-{FlowcellID}, e.g. 000000000-MB4RJ → MB4RJ
 * - Side-prefixed (iSeq, NextSeq, NovaSeq): [AB]{FlowcellID}, e.g. ASC2139476-SC3 → SC2139476-SC3
 *
 * @see https://support-docs.illumina.com/IN/MiSeq_UG_200046664/Content/IN/MiSeq/RunFolder-Naming_fMS.htm MiSeq run folder naming
 * @see https://support-docs.illumina.com/IN/iSeq100/Content/IN/iSeq/OutputFiles_fISQ.htm iSeq 100 output folder structure
 * @see https://support-docs.illumina.com/IN/NovaSeqX/Content/IN/NovaSeqX/OutputFolderStructure.htm NovaSeq X output folder structure
 * @see https://www.biostars.org/p/198143/ Community reference on A/B side prefix for dual-slot instruments
 */
class IlluminaRunFolder
{
    /** MiSeq zero-prefixed format: 000000000-AGKG7 → AGKG7. */
    private const ZERO_PREFIXED_PATTERN = '/^\d+-(.+)$/';

    /**
     * Side-prefixed format: ASC2139476-SC3 → SC2139476-SC3, AH7LFFAFXX → H7LFFAFXX.
     *
     * A/B indicates the flowcell position (side A or B). Originally used by
     * dual-slot instruments (HiSeq, NovaSeq 6000), also present on single-slot
     * instruments (iSeq i100, NextSeq).
     */
    private const SIDE_PREFIXED_PATTERN = '/^[AB](.+)$/';

    public Carbon $date;

    public string $instrumentID;

    public int $runNumber;

    /** Flowcell barcode with zero-prefix or side-prefix (A/B) stripped. */
    public string $flowcellID;

    public function __construct(Carbon $date, string $instrumentID, int $runNumber, string $flowcellID)
    {
        $this->date = $date;
        $this->instrumentID = $instrumentID;
        $this->runNumber = $runNumber;
        $this->flowcellID = $flowcellID;
    }

    /**
     * Accepts both bare folder names and paths with forward or backslashes.
     *
     * @example IlluminaRunFolder::parse('foo\bar\260310_M02074_1219_000000000-MB4RJ')
     * @example IlluminaRunFolder::parse('/path/to/20260205_SH01038_0007_ASC2139476-SC3')
     */
    public static function parse(string $runFolder): self
    {
        // Normalize backslashes so basename() works on Linux with Windows-style paths
        $normalized = str_replace('\\', '/', $runFolder);
        $folderName = basename($normalized);

        $parts = explode('_', $folderName, 4);
        if (count($parts) !== 4) {
            throw new \InvalidArgumentException("Invalid run folder format: {$runFolder}. Expected format: YYYYMMDD_InstrumentID_RunNumber_FlowcellID.");
        }

        [$dateString, $instrumentID, $runNumberString, $flowcellSegment] = $parts;

        if (preg_match('/^(\d{6}|\d{8})$/', $dateString) === 0) {
            throw new \InvalidArgumentException("Invalid date in run folder: {$dateString}. Expected 6 or 8 digit date.");
        }

        $format = strlen($dateString) === 8 ? '!Ymd' : '!ymd';
        $date = Carbon::createFromFormat($format, $dateString);
        if (! $date instanceof Carbon) {
            throw new \InvalidArgumentException("Invalid date in run folder: {$dateString}.");
        }

        if ($runNumberString === '' || ! ctype_digit($runNumberString)) {
            throw new \InvalidArgumentException("Invalid run number in run folder: {$runNumberString}. Expected a numeric value.");
        }

        return new self($date, $instrumentID, (int) $runNumberString, self::extractFlowcellID($flowcellSegment));
    }

    private static function extractFlowcellID(string $flowcellSegment): string
    {
        if (preg_match(self::ZERO_PREFIXED_PATTERN, $flowcellSegment, $matches) === 1) {
            return $matches[1];
        }

        if (preg_match(self::SIDE_PREFIXED_PATTERN, $flowcellSegment, $matches) === 1) {
            return $matches[1];
        }

        throw new \InvalidArgumentException("Cannot extract flowcell ID from: {$flowcellSegment}");
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils;

use Carbon\Carbon;

use function Safe\preg_match;

/**
 * Parses Illumina sequencer run folder names into structured parts.
 *
 * Folder names follow the pattern: YYYYMMDD_InstrumentID_RunNumber_FlowcellSegment
 *
 * Examples:
 * - MiSeq i100:  20260224_SH01038_0011_ASC2168863-SC3
 * - MiSeq:       151231_M01261_0163_000000000-AGKG7
 * - NextSeq:     160205_NB501352_0003_AH7LFFAFXX
 * - MiSeq Nano:  160315_M01111_0231_000000000-D0WDA
 * - Broken RFID: 160108_M01111_0222_AGKKL
 */
class IlluminaRunFolder
{
    public Carbon $date;

    public string $instrumentID;

    public int $runNumber;

    /**
     * The extracted flowcell ID (e.g., AGKG7, ASC2168863-SC3, AH7LFFAFXX).
     *
     * Strips the optional numeric prefix from the raw segment:
     * - 000000000-AGKG7 → AGKG7
     * - ASC2168863-SC3  → ASC2168863-SC3 (no prefix to strip)
     */
    public string $flowcellID;

    public function __construct(Carbon $date, string $instrumentID, int $runNumber, string $flowcellID)
    {
        $this->date = $date;
        $this->instrumentID = $instrumentID;
        $this->runNumber = $runNumber;
        $this->flowcellID = $flowcellID;
    }

    /**
     * Parse a run folder name or path into its structured parts.
     *
     * Accepts both forward and backslash paths.
     *
     * @example IlluminaRunFolder::parse('miseq_active\260310_M02074_1219_000000000-MB4RJ')
     * @example IlluminaRunFolder::parse('/data/sequencing/20260205_SH01038_0007_ASC2139476-SC3')
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

        if (preg_match('/^\d{6,8}$/', $dateString) === 0) {
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

        $flowcellID = self::extractFlowcellID($flowcellSegment);

        return new self($date, $instrumentID, (int) $runNumberString, $flowcellID);
    }

    /**
     * Extract the actual flowcell ID from the raw segment.
     *
     * Illumina run folders encode the flowcell ID in the last segment, optionally
     * prefixed with zeros and a dash (broken RFID readers on older MiSeqs):
     * - 000000000-AGKG7 → AGKG7
     * - 000000000-D0WDA → D0WDA
     * - ASC2168863-SC3  → ASC2168863-SC3
     * - AH7LFFAFXX      → AH7LFFAFXX
     * - AGKKL            → AGKKL
     *
     * @see https://gitlab.mll/nemo/nemo/-/blob/master/scripts/illumina/pipeline/ill-ended.php (flowcell regex)
     */
    private static function extractFlowcellID(string $rawSegment): string
    {
        if (preg_match('/\d*-?([ABCDG].+)$/', $rawSegment, $matches) !== 1) {
            throw new \InvalidArgumentException("Cannot extract flowcell ID from: {$rawSegment}");
        }

        return $matches[1];
    }
}

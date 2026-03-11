<?php declare(strict_types=1);

namespace MLL\Utils;

use Carbon\Carbon;

use function Safe\preg_match;

/**
 * Parses Illumina sequencer run folder names (YYYYMMDD_InstrumentID_RunNumber_FlowcellSegment).
 */
class IlluminaRunFolder
{
    private const FLOWCELL_ID_PATTERN = '/\d*-?([A-Z].+)$/';

    public Carbon $date;

    public string $instrumentID;

    public int $runNumber;

    /** Strips optional zero-prefix from raw segment: 000000000-AGKG7 → AGKG7. */
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

        if (preg_match(self::FLOWCELL_ID_PATTERN, $flowcellSegment, $matches) !== 1) {
            throw new \InvalidArgumentException("Cannot extract flowcell ID from: {$flowcellSegment}");
        }

        return new self($date, $instrumentID, (int) $runNumberString, $matches[1]);
    }
}

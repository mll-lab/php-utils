<?php declare(strict_types=1);

namespace MLL\Utils;

use Carbon\CarbonImmutable;

use function Safe\preg_match;

class IlluminaRunFolder
{
    public CarbonImmutable $date;

    public string $instrumentID;

    public int $runNumber;

    public string $flowcellID;

    public function __construct(CarbonImmutable $date, string $instrumentID, int $runNumber, string $flowcellID)
    {
        $this->date = $date;
        $this->instrumentID = $instrumentID;
        $this->runNumber = $runNumber;
        $this->flowcellID = $flowcellID;
    }

    /** @example IlluminaRunFolder::parse('/path/to/20260205_SH01038_0007_ASC2139476-SC3') */
    public static function parse(string $runFolder): self
    {
        $folderName = basename($runFolder);
        $parts = explode('_', $folderName, 4);
        if (count($parts) !== 4) {
            throw new \InvalidArgumentException("Invalid run folder format: {$runFolder}. Expected format: YYYYMMDD_InstrumentID_RunNumber_FlowcellID.");
        }

        [$dateString, $instrumentID, $runNumberString, $flowcellID] = $parts;

        if (preg_match('/^\d{8}$/', $dateString) === 0) {
            throw new \InvalidArgumentException("Invalid date in run folder: {$dateString}. Expected format: YYYYMMDD.");
        }

        $date = CarbonImmutable::createFromFormat('!Ymd', $dateString);
        if (! $date instanceof \Carbon\CarbonImmutable) {
            throw new \InvalidArgumentException("Invalid date in run folder: {$dateString}. Expected format: YYYYMMDD.");
        }

        if ($runNumberString === '' || ! ctype_digit($runNumberString)) {
            throw new \InvalidArgumentException("Invalid run number in run folder: {$runNumberString}. Expected a numeric value.");
        }

        return new self($date, $instrumentID, (int) $runNumberString, $flowcellID);
    }

    public function toString(): string
    {
        return implode('_', [
            $this->date->format('Ymd'),
            $this->instrumentID,
            str_pad((string) $this->runNumber, 4, '0', STR_PAD_LEFT),
            $this->flowcellID,
        ]);
    }
}

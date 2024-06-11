<?php

namespace MLL\Utils\IlluminaSampleSheet;

use MLL\Utils\IlluminaSampleSheet\V1\NovaSeqSampleSheet;

class SampleSheetVersions
{
    // TODO enum would be nice
    public const V1 = 'V1'; // SampleSheet_NovaSeq6000_Standard.csv
    public const V2 = 'V2'; // TODO check name of file
    public const TCR = 'TCR'; // SampleSheetForTcrExperiment.csv
    public const XP = 'CP'; // SampleSheet_NovaSeq6000_XpWorkflow.csv
    public const MI = 'MI'; // SampleSheet_MiSeq.csv

    public static function getVersions(): array {
        return [
            self::V1,
            self::V2,
            self::TCR,
            self::XP,
            self::MI
        ];
    }


    public static function createSampleSheet($version) {
        if (!in_array($version, self::getVersions())) {
            throw new \Exception("Invalid version: $version");
        }

        switch ($version) {
            case self::V1:
                return new NovaSeqSampleSheet();
            case self::V2:
                return new V2\SampleSheet();
            case self::TCR:
                return new TCR\SampleSheet();
            case self::XP:
                return new XP\SampleSheet();
            case self::MI:
                return new MI\SampleSheet();
        }
    }
}

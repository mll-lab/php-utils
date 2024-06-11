<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\Field;

class FieldConfigV1
{
    public static function get(): array
    {
        return [
            'MLL\Utils\IlluminaSampleSheet\V1\NovaSeqHeaderSection' => [
                new Field('iemFileVersion', true, 'IEMFileVersion', '4'),
                new Field('experimentName', true, 'Experiment Name', null),
            ],
            'MLL\Utils\IlluminaSampleSheet\V1\NovaSeqDataSection' => [
                new Field('sampleID', true, 'Sample_ID', null),
                new Field('sampleName', true, 'Sample_Name', null),
            ],
        ];
    }
}

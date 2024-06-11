<?php
declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\Field;
use MLL\Utils\IlluminaSampleSheet\SectionConfig;

class ConfigV1
{
    /**
     * @return Collection<SectionConfig>
     */
    public static function getSectionConfig(): Collection
    {
        return new Collection([
            new SectionConfig(0, 'MLL\Utils\IlluminaSampleSheet\V1\NovaSeqHeaderSection'),
            new SectionConfig(1, 'MLL\Utils\IlluminaSampleSheet\V1\ReadsSection'),
            new SectionConfig(2, 'MLL\Utils\IlluminaSampleSheet\V1\SettingsSection'),
            new SectionConfig(3, 'MLL\Utils\IlluminaSampleSheet\V1\DataSection'),
        ]);
    }

    public static function getSectionIndex(string $className): int
    {
        return self::getSectionConfig()->first(
            fn (SectionConfig $sectionConfig) => $sectionConfig->className === $className
        )->index;
    }

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
            ]
        ];

    }
}

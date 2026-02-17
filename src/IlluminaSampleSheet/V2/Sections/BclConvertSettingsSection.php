<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

final class BclConvertSettingsSection extends SimpleKeyValueSection
{
    public function headerFields(): array
    {
        return [
            'SoftwareVersion' => '4.1.23',
            'FastqCompressionFormat' => 'gzip',
        ];
    }

    public function requiredFields(): array
    {
        return [
            'SoftwareVersion',
            'FastqCompressionFormat',
        ];
    }

    public function sectionName(): string
    {
        return 'BCLConvert_Settings';
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

final class CloudSettingsSection extends SimpleKeyValueSection
{
    public function headerFields(): array
    {
        return [
            'GeneratedVersion' => '2.6.0.202308300002',
            'Cloud_Workflow' => 'ica_workflow_1',
            'BCLConvert_Pipeline' => 'urn:ilmn:ica:pipeline:d5c7e407-d439-48c8-bce5-b7aec225f6a7#BclConvert_v4_1_23_patch1',
        ];
    }

    public function requiredFields(): array
    {
        return [
            'GeneratedVersion',
            'Cloud_Workflow',
            'BCLConvert_Pipeline',
        ];
    }

    public function sectionName(): string
    {
        return 'Cloud_Settings';
    }
}

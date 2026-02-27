<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;

final class CloudSettingsSection extends SimpleKeyValueSection
{
    /** @var string */
    public const GENERATED_VERSION = '2.6.0.202308300002';
    public const CLOUD_WORKFLOW = 'ica_workflow_1';
    public const BCL_CONVERT_PIPELINE = 'urn:ilmn:ica:pipeline:d5c7e407-d439-48c8-bce5-b7aec225f6a7#BclConvert_v4_1_23_patch1';

    public function __construct()
    {
        parent::__construct(new Collection([
            'GeneratedVersion' => self::GENERATED_VERSION,
            'Cloud_Workflow' => self::CLOUD_WORKFLOW,
            'BCLConvert_Pipeline' => self::BCL_CONVERT_PIPELINE,
        ]));
    }

    public function sectionName(): string
    {
        return 'Cloud_Settings';
    }
}

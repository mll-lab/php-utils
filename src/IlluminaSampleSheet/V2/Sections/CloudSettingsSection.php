<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;

final class CloudSettingsSection extends SimpleKeyValueSection
{
    /** @var string */
    public const GENERATED_VERSION = '2.6.0.202308300002';
    public const CLOUD_WORKFLOW = 'ica_workflow_1';
    public const BCL_CONVERT_PIPELINE = 'urn:ilmn:ica:pipeline:4bdae602-abe4-4230-b0c6-f886af563b26#BclConvert_v4_4_10';

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

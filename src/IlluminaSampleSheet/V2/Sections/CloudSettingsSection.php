<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;

final class CloudSettingsSection extends SimpleKeyValueSection
{
    /** @var string */
    public const GENERATED_VERSION = '2.6.0.202308300002';
    public const CLOUD_WORKFLOW = 'ica_workflow_1';

    public function __construct(string $bclConvertPipeline)
    {
        parent::__construct(new Collection([
            'GeneratedVersion' => self::GENERATED_VERSION,
            'Cloud_Workflow' => self::CLOUD_WORKFLOW,
            'BCLConvert_Pipeline' => $bclConvertPipeline,
        ]));
    }

    public function sectionName(): string
    {
        return 'Cloud_Settings';
    }
}

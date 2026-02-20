<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvertSoftwareVersion;
use MLL\Utils\IlluminaSampleSheet\V2\Enums\FastQCompressionFormat;

final class BclConvertSettingsSection extends SimpleKeyValueSection
{
    public function __construct()
    {
        $fields = new Collection([
            'FastqCompressionFormat' => FastQCompressionFormat::GZIP,
        ]);

        parent::__construct($fields);
    }

    public function performAnalysisOnCloud(): void
    {
        $this->keyValues['SoftwareVersion'] = BclConvertSoftwareVersion::V4_1_23;
    }

    public function performAnalysisLocal(): void
    {
        $this->keyValues['GenerateFastqcMetrics'] = 'true';
    }

    public function sectionName(): string
    {
        return 'BCLConvert_Settings';
    }
}

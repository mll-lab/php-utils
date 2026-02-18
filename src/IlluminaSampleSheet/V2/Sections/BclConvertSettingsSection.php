<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvertSoftwareVersion;
use MLL\Utils\IlluminaSampleSheet\V2\Enums\FastQCompressionFormat;

final class BclConvertSettingsSection extends SimpleKeyValueSection
{
    public function __construct(
        ?BclConvertSoftwareVersion $bclConvertSoftwareVersion
    ) {
        $fields = new Collection([
            'FastqCompressionFormat' => FastQCompressionFormat::GZIP->value,
            'GenerateFastqcMetrics' => 'true',
        ]);
        if ($bclConvertSoftwareVersion instanceof BclConvertSoftwareVersion) {
            $fields->put('SoftwareVersion', $bclConvertSoftwareVersion->value);
        }

        parent::__construct($fields);
    }

    public function sectionName(): string
    {
        return 'BCLConvert_Settings';
    }
}

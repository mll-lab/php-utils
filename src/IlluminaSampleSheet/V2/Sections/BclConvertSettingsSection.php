<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\V2\Enums\FastQCompressionFormat;

final class BclConvertSettingsSection extends SimpleKeyValueSection
{
    use RequiresAnalysisLocationToBeSet;

    public function __construct(string $softwareVersion)
    {
        $fields = new Collection([
            'FastqCompressionFormat' => FastQCompressionFormat::GZIP,
            'SoftwareVersion' => $softwareVersion,
        ]);

        parent::__construct($fields);
    }

    public function performAnalysisOn(AnalysisLocation $analysisLocation): void
    {
        $this->analysisLocation = $analysisLocation;
        if ($analysisLocation->value === AnalysisLocation::LOCAL_MACHINE) {
            $this->keyValues['GenerateFastqcMetrics'] = 'true';
        }
    }

    public function sectionName(): string
    {
        $this->checkIfAnalysisLocationIsSet();

        return 'BCLConvert_Settings';
    }
}

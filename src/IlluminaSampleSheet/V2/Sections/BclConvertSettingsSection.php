<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\V2\BclConvertSoftwareVersion;
use MLL\Utils\IlluminaSampleSheet\V2\Enums\FastQCompressionFormat;

final class BclConvertSettingsSection extends SimpleKeyValueSection
{
    use RequiresAnalysisLocationToBeSet;

    public function __construct()
    {
        $fields = new Collection([
            'FastqCompressionFormat' => FastQCompressionFormat::GZIP,
        ]);

        parent::__construct($fields);
    }

    public function performAnalysisOn(AnalysisLocation $analysisLocation): void
    {
        $this->analysisLocation = $analysisLocation;
        $analysisLocation->value === AnalysisLocation::LOCAL_MACHINE
            ? $this->performAnalysisOnLocalMachine()
            : $this->performAnalysisOnCloud();
    }

    private function performAnalysisOnCloud(): void
    {
        $this->keyValues['SoftwareVersion'] = BclConvertSoftwareVersion::V4_1_23;
    }

    private function performAnalysisOnLocalMachine(): void
    {
        $this->keyValues['GenerateFastqcMetrics'] = 'true';
    }

    public function sectionName(): string
    {
        $this->checkIfAnalysisLocationIsSet();

        return 'BCLConvert_Settings';
    }
}

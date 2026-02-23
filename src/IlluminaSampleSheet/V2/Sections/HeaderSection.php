<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\V2\IndexOrientation;
use MLL\Utils\IlluminaSampleSheet\V2\InstrumentPlatform;

class HeaderSection extends SimpleKeyValueSection
{
    protected const FILE_FORMAT_VERSION = '2';

    public string $runName;

    public IndexOrientation $indexOrientation;

    public InstrumentPlatform $instrumentPlatform;

    public ?string $runDescription;

    public function __construct(
        string             $runName,
        IndexOrientation   $indexOrientationForIndex1,
        InstrumentPlatform $instrumentPlatform,
        ?string            $runDescription
    ) {
        $this->runName = $runName;
        $this->indexOrientation = $indexOrientationForIndex1;
        $this->instrumentPlatform = $instrumentPlatform;
        $this->runDescription = $runDescription;

        $fields = new Collection([
            'FileFormatVersion' => self::FILE_FORMAT_VERSION,
            'RunName' => $this->runName,
            'IndexOrientation' => $this->indexOrientation->value,
            'InstrumentPlatform' => $this->instrumentPlatform->value,
        ]);

        if (! is_null($this->runDescription)) {
            $fields->put('RunDescription', $this->runDescription);
        }

        parent::__construct($fields);
    }

    public function sectionName(): string
    {
        return 'Header';
    }

    public function performAnalysisLocal(): void
    {
        $this->keyValues['AnalysisLocation'] = 'Local';
    }
}

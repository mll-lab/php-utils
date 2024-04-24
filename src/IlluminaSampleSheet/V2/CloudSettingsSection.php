<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class CloudSettingsSection implements SectionInterface
{
    private string $generatedVersion;

    private string $cloudWorkflow;

    private string $bclConvertPipeline;

    public function __construct(
        string $generatedVersion,
        string $cloudWorkflow,
        string $bclConvertPipeline
    ) {
        $this->generatedVersion = $generatedVersion;
        $this->cloudWorkflow = $cloudWorkflow;
        $this->bclConvertPipeline = $bclConvertPipeline;
    }

    public function convertSectionToString(): string
    {
        return '[Cloud_Settings]
GeneratedVersion,' . $this->generatedVersion . "\n"
            . 'Cloud_Workflow,' . $this->cloudWorkflow . "\n"
            . 'BCLConvert_Pipeline,' . $this->bclConvertPipeline . "\n";
    }
}

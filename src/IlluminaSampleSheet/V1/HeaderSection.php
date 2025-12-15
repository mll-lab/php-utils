<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\Section;

class HeaderSection implements Section
{
    public function __construct(
        public ?string $iemFileVersion,
        public ?string $investigatorName,
        public ?string $experimentName,
        public string $date,
        public string $workflow,
        public string $application,
        public string $assay,
        public string $description,
        public string $chemistry
    ) {}

    public function convertSectionToString(): string
    {
        $headerLines = [
            '[Header]',
            "IEMFileVersion,{$this->iemFileVersion}",
            "Investigator Name,{$this->investigatorName}",
            "Experiment Name,{$this->experimentName}",
            "Date,{$this->date}",
            "Workflow,{$this->workflow}",
            "Application,{$this->application}",
            "Assay,{$this->assay}",
            "Description,{$this->description}",
            "Chemistry,{$this->chemistry}",
        ];

        return implode("\n", $headerLines);
    }
}

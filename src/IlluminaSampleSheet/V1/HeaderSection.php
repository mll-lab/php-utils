<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\Section;

class HeaderSection implements Section
{
    public ?string $iemFileVersion;

    public ?string $experimentName;

    public ?string $investigatorName;

    public string $date;

    public string $workflow;

    public string $application;

    public string $assay;

    public string $description;

    public string $chemistry;

    // one format has also Module, library prep kit, Index Kit
    public function __construct(
        string $iemFileVersion, // sometimes nullable
        string $investigatorName, // sometimes nullable
        string $experimentName,
        string $date,
        string $workflow,
        string $application, // sometimes nullable
        string $assay, // sometimes nullable
        string $description,
        string $chemistry // sometimes nullable
    ) {
        $this->chemistry = $chemistry;
        $this->description = $description;
        $this->assay = $assay;
        $this->application = $application;
        $this->workflow = $workflow;
        $this->date = $date;
        $this->investigatorName = $investigatorName;
        $this->experimentName = $experimentName;
        $this->iemFileVersion = $iemFileVersion;
    }

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

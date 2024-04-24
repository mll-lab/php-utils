<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class MiSeqHeaderSection implements SectionInterface
{
    public string $experimentName;

    public string $date;

    public string $module;

    public string $workflow;

    public string $libraryPrepKit;

    public string $indexKit;

    public string $description;

    public string $chemistry;

    public function __construct(
        string $experimentName,
        string $date,
        string $module,
        string $workflow,
        string $libraryPrepKit,
        string $indexKit,
        string $description,
        string $chemistry
    ) {
        $this->experimentName = $experimentName;
        $this->date = $date;
        $this->module = $module;
        $this->workflow = $workflow;
        $this->libraryPrepKit = $libraryPrepKit;
        $this->indexKit = $indexKit;
        $this->description = $description;
        $this->chemistry = $chemistry;
    }

    public function convertSectionToString(): string
    {
        $headerLines = [
            '[Header]',
            "Experiment Name,{$this->experimentName}",
            "Date,{$this->date}",
            "Module,{$this->module}",
            "Workflow,{$this->workflow}",
            "Library Prep Kit,{$this->libraryPrepKit}",
            "Index Kit,{$this->indexKit}",
            "Description,{$this->description}",
            "Chemistry,{$this->chemistry}",
        ];

        return implode("\n", $headerLines);
    }
}

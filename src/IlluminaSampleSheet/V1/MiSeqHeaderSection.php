<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use Carbon\Carbon;
use MLL\Utils\IlluminaSampleSheet\SectionInterface;

class MiSeqHeaderSection implements SectionInterface
{
    public ?string $experimentName;

    public ?Carbon $date;

    public ?string $module;

    public ?string $workflow;

    public ?string $libraryPrepKit;

    public ?string $indexKit;

    public ?string $description;

    public ?string $chemistry;

    public function __construct(
        ?string $experimentName,
        ?Carbon $date,
        ?string $module,
        ?string $workflow,
        ?string $libraryPrepKit,
        ?string $indexKit,
        ?string $description,
        ?string $chemistry
    ) {
        $this->experimentName = $this->validateString($experimentName, 'Experiment Name');
        $this->date = $date;
        $this->module = $this->validateString($module, 'Module');
        $this->workflow = $this->validateString($workflow, 'Workflow');
        $this->libraryPrepKit = $this->validateString($libraryPrepKit, 'Library Prep Kit');
        $this->indexKit = $this->validateString($indexKit, 'Index Kit');
        $this->description = $this->validateString($description, 'Description');
        $this->chemistry = $this->validateString($chemistry, 'Chemistry');
    }

    private function validateString(?string $value, string $fieldName): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmedValue = trim($value);
        if ($trimmedValue === '') {
            throw new \InvalidArgumentException("{$fieldName} cannot be empty.");
        }

        return $trimmedValue;
    }

    public function convertSectionToString(): string
    {
        $headerLines = ['[Header]'];

        if ($this->experimentName !== null) {
            $headerLines[] = "Experiment Name,{$this->experimentName}";
        }

        if ($this->date instanceof Carbon) {
            $headerLines[] = "Date,{$this->date->format('d.m.Y')}";
        }

        if ($this->module !== null) {
            $headerLines[] = "Module,{$this->module}";
        }

        if ($this->workflow !== null) {
            $headerLines[] = "Workflow,{$this->workflow}";
        }

        if ($this->libraryPrepKit !== null) {
            $headerLines[] = "Library Prep Kit,{$this->libraryPrepKit}";
        }

        if ($this->indexKit !== null) {
            $headerLines[] = "Index Kit,{$this->indexKit}";
        }

        if ($this->description !== null) {
            $headerLines[] = "Description,{$this->description}";
        }

        if ($this->chemistry !== null) {
            $headerLines[] = "Chemistry,{$this->chemistry}";
        }

        return implode("\n", $headerLines);
    }
}

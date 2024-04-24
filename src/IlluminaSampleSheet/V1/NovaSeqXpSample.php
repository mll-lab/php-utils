<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

class NovaSeqXpSample extends Sample
{
    public string $lane;

    public string $sampleId;

    public string $sampleName;

    public string $samplePlate;

    public string $sampleWell;

    public string $i7IndexId;

    public string $index;

    public string $i5IndexId;

    public string $index2;

    public string $sampleProject;

    public string $description;

    public function __construct(
        string $lane,
        string $sampleId,
        string $sampleName,
        string $samplePlate,
        string $sampleWell,
        string $i7IndexId,
        string $index,
        string $i5IndexId,
        string $index2,
        string $sampleProject,
        string $description
    ) {
        $this->lane = $lane;
        $this->sampleId = $this->validateSampleId($sampleId);
        $this->sampleName = $this->validateSampleName($sampleName);
        $this->samplePlate = $samplePlate;
        $this->sampleWell = $sampleWell;
        $this->i7IndexId = $i7IndexId;
        $this->index = $this->validateIndex($index);
        $this->i5IndexId = $i5IndexId;
        $this->index2 = $this->validateIndex($index2);
        $this->sampleProject = $sampleProject;
        $this->description = $description;
    }

    public function toString(): string
    {
        return implode(',', [
            $this->lane,
            $this->sampleId,
            $this->sampleName,
            $this->samplePlate,
            $this->sampleWell,
            $this->i7IndexId,
            $this->index,
            $this->i5IndexId,
            $this->index2,
            $this->sampleProject,
            $this->description,
        ]);
    }
}

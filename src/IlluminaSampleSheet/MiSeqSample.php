<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class MiSeqSample extends Sample
{
    public string $sampleId;

    public string $sampleName;

    public string $samplePlate;

    public string $sampleWell;

    public string $sampleProject;

    public string $i7IndexId;

    public string $index;

    public string $i5IndexId;

    public string $index2;

    public function __construct(
        string $sampleId,
        string $sampleName,
        string $samplePlate,
        string $sampleWell,
        string $sampleProject,
        string $i7IndexId,
        string $index,
        string $i5IndexId,
        string $index2
    ) {
        $this->sampleId = $this->validateSampleId($sampleId);
        $this->sampleName = $this->validateSampleName($sampleName);
        $this->samplePlate = $samplePlate;
        $this->sampleWell = $sampleWell;
        $this->sampleProject = $sampleProject;
        $this->i7IndexId = $i7IndexId;
        $this->index = $this->validateIndex($index);
        $this->i5IndexId = $i5IndexId;
        $this->index2 = $this->validateIndex($index2);
    }

    public function toString(): string
    {
        return implode(',', [
            $this->sampleId,
            $this->sampleName,
            $this->samplePlate,
            $this->sampleWell,
            $this->sampleProject,
            $this->i7IndexId,
            $this->index,
            $this->i5IndexId,
            $this->index2,
        ]);
    }
}

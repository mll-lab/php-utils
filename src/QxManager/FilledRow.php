<?php declare(strict_types=1);

namespace MLL\Utils\QxManager;

class FilledRow
{
    private readonly string $experimentType;

    private readonly string $supermixName;

    private readonly string $assayType;

    private readonly string $targetType;

    private readonly string $plot;

    private readonly string $targetName;

    private readonly string $signalCh1;

    private readonly string $signalCh2;

    private readonly string $sampleDescription1;

    private readonly ?string $sampleDescription2;

    private readonly ?string $sampleDescription3;

    private readonly ?string $sampleDescription4;

    private readonly string $sampleType;

    private readonly ?int $referenceCopies;

    private readonly ?string $wellNotes;

    private readonly ?string $rdqConversionFactor;

    public function __construct(
        string $sampleDescription1,
        ?string $sampleDescription2,
        ?string $sampleDescription3,
        ?string $sampleDescription4,
        string $sampleType,
        string $experimentType,
        string $supermixName,
        string $assayType,
        string $targetType,
        string $plot,
        string $targetName,
        string $signalCh1,
        string $signalCh2,
        ?int $referenceCopies = null,
        ?string $wellNotes = null,
        ?string $rdqConversionFactor = null
    ) {
        $this->targetName = $targetName;
        $this->signalCh1 = $signalCh1;
        $this->signalCh2 = $signalCh2;
        $this->sampleDescription1 = $sampleDescription1;
        $this->sampleDescription2 = $sampleDescription2;
        $this->sampleDescription3 = $sampleDescription3;
        $this->sampleDescription4 = $sampleDescription4;
        $this->sampleType = $sampleType;
        $this->experimentType = $experimentType;
        $this->supermixName = $supermixName;
        $this->assayType = $assayType;
        $this->targetType = $targetType;
        $this->plot = $plot;
        $this->referenceCopies = $referenceCopies;
        $this->wellNotes = $wellNotes;
        $this->rdqConversionFactor = $rdqConversionFactor;
    }

    public function toString(): string
    {
        return implode(QxManagerSampleSheet::DELIMITER, [
            'Yes',
            $this->experimentType,
            $this->sampleDescription1,
            $this->sampleDescription2,
            $this->sampleDescription3,
            $this->sampleDescription4,
            $this->sampleType,
            $this->supermixName,
            $this->assayType,
            $this->targetName,
            $this->targetType,
            $this->signalCh1,
            $this->signalCh2,
            $this->referenceCopies,
            $this->wellNotes,
            $this->plot,
            $this->rdqConversionFactor,
        ]);
    }
}

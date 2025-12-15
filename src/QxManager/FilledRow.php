<?php declare(strict_types=1);

namespace MLL\Utils\QxManager;

class FilledRow
{
    public function __construct(
        private readonly string $sampleDescription1,
        private readonly ?string $sampleDescription2,
        private readonly ?string $sampleDescription3,
        private readonly ?string $sampleDescription4,
        private readonly string $sampleType,
        private readonly string $experimentType,
        private readonly string $supermixName,
        private readonly string $assayType,
        private readonly string $targetType,
        private readonly string $plot,
        private readonly string $targetName,
        private readonly string $signalCh1,
        private readonly string $signalCh2,
        private readonly ?int $referenceCopies = null,
        private readonly ?string $wellNotes = null,
        private readonly ?string $rdqConversionFactor = null
    ) {}

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

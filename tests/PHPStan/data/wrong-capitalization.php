<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\data;

class LabIdProcessor
{
    private int $patientId = 1;

    public function getLabId(): int
    {
        return $this->patientId;
    }

    public function processLabId(int $labId): void
    {
        $sampleId = $labId;
    }
}

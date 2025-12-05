<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\data;

class LabIdProcessor
{
    public function getLabId(): int
    {
        return 1;
    }

    public function processLabId(int $labId): void
    {
        $sampleId = $labId;
    }
}

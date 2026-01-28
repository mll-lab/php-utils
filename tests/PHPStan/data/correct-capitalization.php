<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\data;

class CorrectCapitalization
{
    private int $patientID = 1;

    public function getLabID(): int
    {
        return $this->patientID;
    }

    public function processLabID(int $labID): void
    {
        $sampleID = $labID;
        $id = 1;
    }

    public function getIdentifier(): string
    {
        return 'test';
    }

    public function isIdentical(int $a, int $b): bool
    {
        return $a === $b;
    }
}

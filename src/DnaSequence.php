<?php declare(strict_types=1);

namespace MLL\Utils;

class DnaSequence
{
    protected string $validatedSequence;

    public function __construct(string $sequence)
    {
        $sequence = trim(strtoupper($sequence));
        if (\Safe\preg_match('/^[ATGC]*$/', $sequence) === 0) {
            throw new \InvalidArgumentException('Invalid DNA sequence');
        }
        $this->validatedSequence = $sequence;
    }

    public function reverse(): string
    {
        $parts = mb_str_split($this->validatedSequence); // @phpstan-ignore-line theCodingMachineSafe.function (safe from PHP 8.0)
        $reversedParts = array_reverse($parts);

        return implode($reversedParts);
    }

    public function complement(): string
    {
        return $this->complementSequence($this->validatedSequence);
    }

    public function reverseComplement(): string
    {
        return $this->complementSequence($this->reverse());
    }

    private function complementSequence(string $sequence): string
    {
        return strtr($sequence, [
            'A' => 'T',
            'T' => 'A',
            'G' => 'C',
            'C' => 'G',
        ]);
    }

    public function toString(): string
    {
        return $this->validatedSequence;
    }

    public function length(): int
    {
        return strlen($this->validatedSequence);
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils;

class DnaSequence
{
    protected string $sequence;

    public function __construct(string $sequence)
    {
        if (\Safe\preg_match('/^[ATGC]*$/', $sequence) === 0) {
            throw new \InvalidArgumentException('Invalid DNA sequence');
        }
        $this->sequence = $sequence;
    }

    public function reverse(): string
    {
        $parts = mb_str_split($this->sequence); // @phpstan-ignore-line theCodingMachineSafe.function (safe from PHP 8.0)
        $reversedParts = array_reverse($parts);

        return implode('', $reversedParts);
    }

    public function complement(): string
    {
        return $this->complementSequence($this->sequence);
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
}

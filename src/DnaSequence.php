<?php declare(strict_types=1);

namespace MLL\Utils;

use Illuminate\Support\Str;

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
        return Str::reverse($this->sequence);
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
        return Str::swap([
            'A' => 'T',
            'T' => 'A',
            'G' => 'C',
            'C' => 'G',
        ], $sequence);
    }
}

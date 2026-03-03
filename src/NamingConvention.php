<?php declare(strict_types=1);

namespace MLL\Utils;

class NamingConvention
{
    public const ENSEMBL = 'ENSEMBL';
    public const UCSC = 'UCSC';

    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}

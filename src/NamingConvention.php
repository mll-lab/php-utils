<?php declare(strict_types=1);

namespace MLL\Utils;

class NamingConvention
{
    public const ENSEMBL = 'ENSEMBL';
    public const UCSC = 'UCSC';

    public string $value;

    public function __construct(string $value)
    {
        switch ($value) {
            case NamingConvention::ENSEMBL:
            case NamingConvention::UCSC:
                $this->value = $value;
                break;
            default:
                throw new \InvalidArgumentException("Invalid naming convention: {$value}");
        }
    }
}

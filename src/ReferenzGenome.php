<?php declare(strict_types=1);

namespace MLL\Utils;

class ReferenzGenome
{
    public const HG_19 = 'HG_19';
    public const GRCH_37 = 'GRCH_37';

    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class NucleotideType
{
    public const R1 = 'R1';
    public const I1 = 'I1';
    public const I2 = 'I2';
    public const R2 = 'R2';

    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

}

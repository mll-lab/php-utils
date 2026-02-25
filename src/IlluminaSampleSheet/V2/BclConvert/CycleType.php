<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class CycleType
{
    public const READ_CYCLE = 'Y';
    public const TRIMMED_CYCLE = 'N';
    public const UMI_CYCLE = 'U';
    public const INDEX_CYCLE = 'I';

    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

}

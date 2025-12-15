<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

class CycleType
{
    public const READ_CYCLE = 'Y';
    public const TRIMMED_CYCLE = 'N';
    public const UMI_CYCLE = 'U';
    public const INDEX_CYCLE = 'I';

    public function __construct(
        public string $value
    ) {}

    public static function READ_CYCLE(): self
    {
        return new static(self::READ_CYCLE);
    }

    public static function TRIMMED_CYCLE(): self
    {
        return new static(self::TRIMMED_CYCLE);
    }

    public static function UMI_CYCLE(): self
    {
        return new static(self::UMI_CYCLE);
    }

    public static function INDEX_CYCLE(): self
    {
        return new static(self::INDEX_CYCLE);
    }
}

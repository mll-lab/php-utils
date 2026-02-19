<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

class BclConvertSoftwareVersion
{
    public const V4_1_23 = '4.1.23';

    /** @var string */
    public $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function V4_1_23(): self
    {
        return new self(self::V4_1_23);
    }
}

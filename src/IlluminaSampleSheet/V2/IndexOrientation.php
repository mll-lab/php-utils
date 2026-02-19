<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

class IndexOrientation
{
    public const FORWARD = 'Forward';
    public const REVERSE = 'Reverse';

    /** @var string */
    public $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function FORWARD(): self
    {
        return new self(self::FORWARD);
    }

    public static function REVERSE(): self
    {
        return new self(self::REVERSE);
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Enums;

class FastQCompressionFormat
{
    public const GZIP = 'gzip';
    public const DRAGEN = 'dragen';

    public function __construct(
        public string $value
    ) {}

    public static function GZIP(): self
    {
        return new static(self::GZIP);
    }

    public static function DRAGEN(): self
    {
        return new static(self::DRAGEN);
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Enums;

class FastQCompressionFormat
{
    public const GZIP = 'gzip';
    public const DRAGEN = 'dragen';

    /** @var string */
    public $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

class InstrumentPlatform
{
    public const NOVASEQ_X_SERIES = 'NovaSeqXSeries';
    public const MISEQ_I100_SERIES = 'MiSeqi100Series';

    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function NOVASEQ_X_SERIES(): self
    {
        return new self(self::NOVASEQ_X_SERIES);
    }

    public static function MISEQ_I100_SERIES(): self
    {
        return new self(self::MISEQ_I100_SERIES);
    }
}

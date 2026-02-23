<?php

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

class AnalysisLocation
{
    public const LOCAL_MACHINE = 'LOCAL_MACHINE';
    public const CLOUD = 'CLOUD';

    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function LOCAL_MACHINE(): self
    {
        return new self(self::LOCAL_MACHINE);
    }

    public static function CLOUD(): self
    {
        return new self(self::CLOUD);
    }
}
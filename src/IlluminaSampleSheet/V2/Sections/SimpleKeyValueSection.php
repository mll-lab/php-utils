<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\Section;

abstract class SimpleKeyValueSection implements Section
{
    /** @var Collection<string, string> */
    private $keyValues;

    /**
     * @param Collection<string, string> $keyValues
     */
    public function __construct(Collection $keyValues)
    {
        $this->keyValues = $keyValues;
    }

    public function convertSectionToString(): string
    {
        return
            $this->keyValues
                ->map(fn (string $value, string $key): string => "{$key},{$value}")
                ->join(PHP_EOL)
            . PHP_EOL;
    }
}

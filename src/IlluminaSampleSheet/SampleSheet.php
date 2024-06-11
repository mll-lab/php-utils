<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

use Illuminate\Support\Collection;

abstract class SampleSheet
{
    /** @var Collection<Section> */
    protected Collection $sections;

    public function __construct()
    {
        $this->sections = new Collection([]);
    }

    public function addSection(Section $section, $order): void
    {
        $this->sections->put($order, $section);
    }

    public function toString(): string
    {
        return $this->sections
            ->sortKeys()
            ->map(
                fn (Section $section): string => $section->convertSectionToString(),
            )
            ->implode("\n");
    }
}

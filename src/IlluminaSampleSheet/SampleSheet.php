<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

abstract class SampleSheet
{
    /** @var array<Section> */
    protected array $sections = [];

    public function addSection(Section $section): void
    {
        $this->sections[] = $section;
    }

    public function toString(): string
    {
        return implode("\n", array_map(fn (Section $section) => $section->convertSectionToString(), $this->sections));
    }

    /** @return array<Section> */
    public function getSections(): array
    {
        return $this->sections;
    }
}

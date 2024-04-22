<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

abstract class SampleSheet
{
    /** @var array<SectionInterface> */
    protected array $sections = [];

    public function addSection(SectionInterface $section): void
    {
        $this->sections[] = $section;
    }

    public function toString(): string
    {
        return implode("\n", array_map(fn (SectionInterface $section) => $section->toString(), $this->sections));
    }

    /** @return array<SectionInterface> */
    public function getSections(): array
    {
        return $this->sections;
    }
}

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
        $sectionStrings = array_map(
            fn (SectionInterface $section): string => $section->convertSectionToString(),
            $this->sections
        );

        return implode("\n", $sectionStrings);
    }

    /** @return array<SectionInterface> */
    public function getSections(): array
    {
        return $this->sections;
    }
}

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
        $sectionStrings = array_map(
            fn (Section $section): string => $section->convertSectionToString(),
            $this->sections
        );

        return implode("\n", $sectionStrings);
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

interface Section
{
    public function convertSectionToString(): string;
    public function sectionName(): string;
}

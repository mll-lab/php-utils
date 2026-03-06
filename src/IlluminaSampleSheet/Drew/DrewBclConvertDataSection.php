<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\Drew;

use Illuminate\Support\Collection;
use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;
use MLL\Utils\IlluminaSampleSheet\Section;

class DrewBclConvertDataSection implements Section
{
    protected const HEADER_ROW = 'Sample_Name,Description';

    /** @var Collection<int, DrewSample> */
    public Collection $samples;

    /** @param Collection<int, DrewSample> $samples */
    public function __construct(Collection $samples)
    {
        $this->samples = $samples;
    }

    public function convertSectionToString(): string
    {
        if ($this->samples->isEmpty()) {
            throw new IlluminaSampleSheetException('At least one sample must be added to the DataSection.');
        }

        return self::HEADER_ROW . PHP_EOL
            . $this->samples
                ->map(fn (DrewSample $sample): string => $sample->toString())
                ->join(PHP_EOL) . PHP_EOL;
    }

    public function sectionName(): string
    {
        return 'BCLConvert_Data';
    }
}

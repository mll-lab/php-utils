<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

enum InstrumentPlatform: string
{
    case NOVASEQ_X_SERIES = 'NovaSeqXSeries';
    case MISEQ_I100_SERIES = 'MiSeqi100Series';
}

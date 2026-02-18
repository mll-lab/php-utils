<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Enums;

enum FastQCompressionFormat: string
{
    case GZIP = 'gzip';
    case DRAGEN = 'dragen';
}

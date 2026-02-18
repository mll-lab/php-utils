<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\BclConvert;

enum CycleType: string
{
    case READ_CYCLE = 'Y';
    case TRIMMED_CYCLE = 'N';
    case UMI_CYCLE = 'U';
    case INDEX_CYCLE = 'I';
}

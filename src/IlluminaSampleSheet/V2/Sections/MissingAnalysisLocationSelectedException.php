<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

class MissingAnalysisLocationSelectedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Analysis location has to be set');
    }
}

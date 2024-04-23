<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Exceptions;

use MLL\Utils\Microplate\Enums\FlowDirection;

class UnexpectedFlowDirection extends \UnexpectedValueException
{
    public function __construct(FlowDirection $flowDirection)
    {
        parent::__construct("Unexpected flow direction value: {$flowDirection->value}.");
    }
}

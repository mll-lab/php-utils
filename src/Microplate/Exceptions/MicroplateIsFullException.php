<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Exceptions;

final class MicroplateIsFullException extends \UnexpectedValueException
{
    public function __construct()
    {
        parent::__construct('No free spots left on plate');
    }
}
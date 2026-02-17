<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2;

final class MissingRequiredFieldException extends \Exception
{
    public function __construct(string $requiredField)
    {
        parent::__construct("Missing required field '{$requiredField}', please check the array requiredFields");
    }
}

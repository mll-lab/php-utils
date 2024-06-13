<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;

use function Safe\preg_match;

class SingleIndex extends Index
{
    public string $index;

    public function __construct(string $index)
    {
        $this->index = $index;
        $this->validate();
    }

    public function validate(): void
    {
        $this->validateIndex($this->index);
    }
}

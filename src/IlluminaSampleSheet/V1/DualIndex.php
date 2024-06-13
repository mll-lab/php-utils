<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

use MLL\Utils\IlluminaSampleSheet\IlluminaSampleSheetException;

use function Safe\preg_match;

class DualIndex extends Index
{
    public string $i7IndexID;

    public string $index;

    public string $i5IndexID;

    public string $index2;

    public function __construct(string $i7IndexID, string $index, string $i5IndexID, string $index2)
    {
        $this->i7IndexID = $i7IndexID;
        $this->index = $index;
        $this->i5IndexID = $i5IndexID;
        $this->index2 = $index2;

        $this->validate();
    }

    public function validate(): void
    {
        $this->validateIndex($this->index);
        $this->validateIndex($this->index2);
    }
}

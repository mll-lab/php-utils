<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V1;

class DualIndex extends Index
{
    public function __construct(
        public string $i7IndexID,
        public string $index,
        public string $i5IndexID,
        public string $index2
    ) {
        $this->validate();
    }

    public function validate(): void
    {
        $this->validateIndex($this->index);
        $this->validateIndex($this->index2);
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet;

class Field
{
    public string $name;

    public bool $required;

    public string $fileName;

    public $defaultValue;

    /** @var callable */
    public $validator;

    /**
     * @param string|int|null $defaultValue
     */
    public function __construct(string $name, bool $required, string $fileName, $defaultValue, ?callable $validator = null)
    {
        $this->name = $name;
        $this->required = $required;
        $this->fileName = $fileName;
        $this->defaultValue = $defaultValue;
        $this->validator = $validator;
        if (is_null($validator)) {
            $this->validator = fn () => true;
        }
    }

    public function isValid($value): bool
    {
        return ($this->validator)($value);
    }

    public function hasValidator(): bool
    {
        return ! is_null($this->validator);
    }
}

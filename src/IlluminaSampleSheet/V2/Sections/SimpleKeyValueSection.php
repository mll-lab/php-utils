<?php declare(strict_types=1);

namespace MLL\Utils\IlluminaSampleSheet\V2\Sections;

use MLL\Utils\IlluminaSampleSheet\Section;
use MLL\Utils\IlluminaSampleSheet\V2\MissingRequiredFieldException;

abstract class SimpleKeyValueSection implements Section
{
    /** @var array<string, string> */
    protected array $headerFields = [];

    abstract public function sectionName(): string;

    /** @return array<string, string> */
    abstract public function headerFields(): array;

    /** @return string[] */
    abstract public function requiredFields(): array;

    public function __construct()
    {
        $this->headerFields = $this->headerFields();
    }

    public function setCustomAttribute(string $key, string $value): void
    {
        $this->headerFields[$key] = $value;
    }

    public function checkIfAllRequiredFieldsExists(): void
    {
        foreach ($this->requiredFields() as $requiredField) {
            if (! $this->requiredFieldExists($requiredField)) {
                throw new MissingRequiredFieldException($requiredField);
            }
        }
    }

    public function requiredFieldExists(string $key): bool
    {
        return isset($this->headerFields[$key]);
    }

    public function convertSectionToString(): string
    {
        $this->checkIfAllRequiredFieldsExists();

        return
            "[{$this->sectionName()}]" . PHP_EOL
            . join(PHP_EOL, array_map(
                fn (string $value, string $key): string => "{$key},{$value}",
                $this->headerFields,
                array_keys($this->headerFields),
            ));
    }
}

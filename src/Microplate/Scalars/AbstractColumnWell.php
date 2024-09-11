<?php declare(strict_types=1);

namespace MLL\Utils\Microplate\Scalars;

use GraphQL\Error\Error;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Language\AST\Node;
use GraphQL\Language\Printer;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

abstract class AbstractColumnWell extends ScalarType
{
    public ?string $description;

    abstract public function maxInt(): int;
    abstract public function minInt(): int;

    public function serialize($value)
    {
        if (is_int($value) && $this->isValueInExpectedRange($value)) {
            return $value;
        }

        $notInRange = Utils::printSafe($value);
        throw new \InvalidArgumentException("Value not in range: {$notInRange}.");
    }

    public function parseValue($value)
    {
        if (is_int($value) && $this->isValueInExpectedRange($value)) {
            return $value;
        }

        $notInRange = Utils::printSafe($value);
        throw new Error("Value not in range: {$notInRange}.");
    }

    public function parseLiteral(Node $valueNode, ?array $variables = null)
    {
        if ($valueNode instanceof IntValueNode) {
            $value = (int) $valueNode->value;
            if ($this->isValueInExpectedRange($value)) {
                return $value;
            }
        }

        $notInRange = Printer::doPrint($valueNode);
        throw new Error("Value not in range: {$notInRange}.", $valueNode);
    }

    private function isValueInExpectedRange(int $value): bool
    {
        return $value <= $this->maxInt() && $value >= $this->minInt();
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node> */
abstract class CanonicalCapitalizationRule implements Rule
{
    /** The correct canonical form, e.g. "Lab ID". */
    abstract protected function getCanonicalForm(): string;

    /** @return array<int, string> Wrong variants to detect, e.g. ['LabID', 'labID', 'LABID']. */
    abstract protected function getWrongVariants(): array;

    abstract protected function getErrorIdentifier(): string;

    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $nodeName = $this->extractName($node);

        if ($nodeName === null) {
            return [];
        }

        $wrongVariant = $this->findWrongVariant($nodeName);

        if ($wrongVariant === null) {
            return [];
        }

        $expectedName = $this->fixCapitalization($nodeName, $wrongVariant);
        $displayName = $this->formatNameForMessage($node, $nodeName);
        $displayExpectedName = $this->formatNameForMessage($node, $expectedName);

        return [
            RuleErrorBuilder::message(<<<TXT
                Name of {$node->getType()} "{$displayName}" should use "{$this->getCanonicalForm()}" instead of "{$wrongVariant}", rename it to "{$displayExpectedName}".
                TXT)
                ->identifier($this->getErrorIdentifier())
                ->build(),
        ];
    }

    protected function extractName(Node $node): ?string
    {
        if ($node instanceof Variable && is_string($node->name)) {
            return $node->name;
        }

        if ($node instanceof Param && $node->var instanceof Variable && is_string($node->var->name)) {
            return $node->var->name;
        }

        if ($node instanceof ClassMethod) {
            return $node->name->name;
        }

        if ($node instanceof Class_ && $node->name instanceof Identifier) {
            return $node->name->name;
        }

        if ($node instanceof String_) {
            return $node->value;
        }

        return null;
    }

    protected function formatNameForMessage(Node $node, string $name): string
    {
        if ($node instanceof Variable || $node instanceof Param) {
            return '$' . $name;
        }

        return $name;
    }

    protected function findWrongVariant(string $nodeName): ?string
    {
        foreach ($this->getWrongVariants() as $wrongVariant) {
            if (Str::contains($nodeName, $wrongVariant)) {
                return $wrongVariant;
            }
        }

        return null;
    }

    protected function fixCapitalization(string $nodeName, string $wrongVariant): string
    {
        return str_replace($wrongVariant, $this->getCanonicalForm(), $nodeName);
    }
}

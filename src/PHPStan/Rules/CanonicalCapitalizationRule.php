<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use PhpParser\Node;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Enforces canonical capitalization in string literals.
 *
 * Only checks string literals because canonical forms like "Lab ID" contain spaces,
 * which are invalid in PHP identifiers (variables, methods, classes).
 * Per coding guidelines: "Unless the circumstances demand otherwise (all lower, no spaces, ...)".
 *
 * @implements Rule<String_>
 */
abstract class CanonicalCapitalizationRule implements Rule
{
    /** The correct canonical form, e.g. "Lab ID". */
    abstract protected function getCanonicalForm(): string;

    /** @return array<int, string> Wrong variants to detect, e.g. ['LabID', 'labID', 'LABID']. */
    abstract protected function getWrongVariants(): array;

    abstract protected function getErrorIdentifier(): string;

    public function getNodeType(): string
    {
        return String_::class;
    }

    /** @param String_ $node */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($this->hasGraphQLAnnotation($node)) {
            return [];
        }

        $value = $node->value;

        if ($this->looksLikeIdentifier($value)) {
            return [];
        }

        $wrongVariant = $this->findWrongVariant($value);

        if ($wrongVariant === null) {
            return [];
        }

        $expectedValue = $this->fixCapitalization($value, $wrongVariant);

        return [
            RuleErrorBuilder::message(<<<TXT
                String "{$value}" should use "{$this->getCanonicalForm()}" instead of "{$wrongVariant}", change it to "{$expectedValue}".
                TXT)
                ->identifier($this->getErrorIdentifier())
                ->build(),
        ];
    }

    /** Identifiers (array keys, field names) can't contain spaces, so skip them. */
    protected function looksLikeIdentifier(string $value): bool
    {
        return \Safe\preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $value) === 1;
    }

    /** GraphQL queries are annotated with @lang GraphQL and use field names that can't contain spaces. */
    protected function hasGraphQLAnnotation(String_ $node): bool
    {
        foreach ($node->getComments() as $comment) {
            if (Str::contains($comment->getText(), '@lang GraphQL')) {
                return true;
            }
        }

        return false;
    }

    protected function findWrongVariant(string $value): ?string
    {
        foreach ($this->getWrongVariants() as $wrongVariant) {
            if (Str::contains($value, $wrongVariant)) {
                return $wrongVariant;
            }
        }

        return null;
    }

    protected function fixCapitalization(string $value, string $wrongVariant): string
    {
        return str_replace($wrongVariant, $this->getCanonicalForm(), $value);
    }
}

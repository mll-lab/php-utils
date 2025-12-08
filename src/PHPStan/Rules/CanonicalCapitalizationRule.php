<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use PhpParser\Node;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Only checks string literals because canonical forms like "Lab ID" contain spaces,
 * which are invalid in PHP identifiers (variables, methods, classes).
 *
 * @implements Rule<String_>
 */
abstract class CanonicalCapitalizationRule implements Rule
{
    abstract protected function getCanonicalForm(): string;

    /** @return array<int, string> */
    abstract protected function getWrongVariants(): array;

    abstract protected function getErrorIdentifier(): string;

    public function getNodeType(): string
    {
        return String_::class;
    }

    /** @param String_ $node */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($this->hasLanguageAnnotation($node)) {
            return [];
        }

        $value = $node->value;

        if ($this->cannotContainSpaces($value)) {
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

    protected function cannotContainSpaces(string $value): bool
    {
        return ! str_contains($value, ' ');
    }

    /** @see https://www.jetbrains.com/help/phpstorm/using-language-injections.html */
    protected function hasLanguageAnnotation(String_ $node): bool
    {
        foreach ($node->getComments() as $comment) {
            if (Str::contains($comment->getText(), '@lang')) {
                return true;
            }
        }

        return false;
    }

    public function findWrongVariant(string $value): ?string
    {
        foreach ($this->getWrongVariants() as $wrongVariant) {
            if (Str::contains($value, $wrongVariant)) {
                return $wrongVariant;
            }
        }

        return null;
    }

    public function fixCapitalization(string $value, string $wrongVariant): string
    {
        return str_replace($wrongVariant, $this->getCanonicalForm(), $value);
    }
}

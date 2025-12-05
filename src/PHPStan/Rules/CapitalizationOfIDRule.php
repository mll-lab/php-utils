<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Abstract base class for rules that check "ID" capitalization.
 *
 * Provides shared logic for detecting and fixing "Id" -> "ID" in names.
 * Concrete implementations check specific node types (variables, parameters, methods, classes).
 *
 * @see VariableNameIdToIDRule
 * @see ParameterNameIdToIDRule
 * @see MethodNameIdToIDRule
 * @see ClassNameIdToIDRule
 *
 * @implements Rule<Node>
 */
abstract class CapitalizationOfIDRule implements Rule
{
    /**
     * Lists words or phrases that contain "Id" but are fine.
     *
     * @var array<int, string>
     */
    protected const FALSE_POSITIVES = [
        'Identifier',
        'Identical',
        'Identity',
        'Idt', // IDT is an abbreviation for the brand "Integrated DNA Technologies, Inc."
    ];

    /** Returns the PHPStan error identifier for this rule. */
    abstract protected function getErrorIdentifier(): string;

    /** Extracts the name from the node, or null if not applicable. */
    abstract protected function extractName(Node $node): ?string;

    public function processNode(Node $node, Scope $scope): array
    {
        $nodeName = $this->extractName($node);

        if ($nodeName === null) {
            return [];
        }

        if (! self::containsWrongIDCapitalization($nodeName)) {
            return [];
        }

        $expectedName = self::fixIDCapitalization($nodeName);

        return [
            RuleErrorBuilder::message(<<<TXT
                Name of {$node->getType()} "{$nodeName}" should use "ID" instead of "Id", rename it to "{$expectedName}".
                TXT)
                ->identifier($this->getErrorIdentifier())
                ->build(),
        ];
    }

    public static function containsWrongIDCapitalization(string $nodeName): bool
    {
        return \Safe\preg_match('/Id/', $nodeName) === 1
            && ! Str::contains($nodeName, self::FALSE_POSITIVES);
    }

    public static function fixIDCapitalization(string $nodeName): string
    {
        if ($nodeName === 'Id') {
            return 'id';
        }

        return str_replace('Id', 'ID', $nodeName);
    }
}

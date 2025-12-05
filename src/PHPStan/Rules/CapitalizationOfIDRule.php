<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node> */
abstract class CapitalizationOfIDRule implements Rule
{
    /** @var array<int, string> */
    protected const FALSE_POSITIVES = [
        'Identifier',
        'Identical',
        'Identity',
        'Idt', // IDT is an abbreviation for the brand "Integrated DNA Technologies, Inc."
    ];

    abstract protected function getErrorIdentifier(): string;

    abstract protected function extractName(Node $node): ?string;

    /** Override for custom formatting (e.g., adding $ prefix for variables). */
    protected function formatNameForMessage(string $name): string
    {
        return $name;
    }

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
        $displayName = $this->formatNameForMessage($nodeName);
        $displayExpectedName = $this->formatNameForMessage($expectedName);

        return [
            RuleErrorBuilder::message(<<<TXT
                Name of {$node->getType()} "{$displayName}" should use "ID" instead of "Id", rename it to "{$displayExpectedName}".
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

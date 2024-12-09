<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use MLL\Utils\PHPStan\NodeNameExtractor\ClassMethodNameExtractor;
use MLL\Utils\PHPStan\NodeNameExtractor\ClassNameExtractor;
use MLL\Utils\PHPStan\NodeNameExtractor\VariableNameExtractor;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node> */
class CapitalizationOfIDRule implements Rule
{
    /** Lists words or phrases that contain "Id" but are fine. */
    protected const FALSE_POSITIVES = [
        'Identifier',
        'Identical',
        'Idt', // IDT is an abbreviation for the brand "Integrated DNA Technologies, Inc."
    ];

    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $extractors = [
            new ClassMethodNameExtractor(),
            new ClassNameExtractor(),
            new VariableNameExtractor(),
        ];
        $nodeName = null;
        foreach ($extractors as $extractor) {
            $extractedName = $extractor->extract($node);
            if ($extractedName !== null) {
                $nodeName = $extractedName;
                break;
            }
        }

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
                ->identifier('mll.capitalizationOfID')
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

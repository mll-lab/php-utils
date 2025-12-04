<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use Illuminate\Support\Str;
use MLL\Utils\PHPStan\NodeNameExtractor\ClassNameExtractor;
use MLL\Utils\PHPStan\NodeNameExtractor\MethodNameExtractor;
use MLL\Utils\PHPStan\NodeNameExtractor\NodeNameExtractor;
use MLL\Utils\PHPStan\NodeNameExtractor\ParameterNameExtractor;
use MLL\Utils\PHPStan\NodeNameExtractor\VariableNameExtractor;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Checks that "ID" is used instead of "Id" in names.
 *
 * Can be configured to check variables, parameters, methods, and/or classes.
 *
 * To enable via phpstan.neon configuration:
 *
 *     parameters:
 *         mllCapitalizationOfID:
 *             enabled: true
 *             checkVariables: true
 *             checkParameters: true
 *             checkMethods: true
 *             checkClasses: true
 *
 * Or add directly to rules: section for default (all checks enabled):
 *
 *     rules:
 *         - MLL\Utils\PHPStan\Rules\CapitalizationOfIDRule
 *
 * For variables-only checking (backwards compatible), use VariableNameIdToIDRule.
 *
 * @implements Rule<Node>
 */
class CapitalizationOfIDRule implements Rule
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

    /** @var array<NodeNameExtractor> */
    private array $extractors;

    public function __construct(
        bool $checkVariables = true,
        bool $checkParameters = true,
        bool $checkMethods = true,
        bool $checkClasses = true
    ) {
        $this->extractors = $this->buildExtractors($checkVariables, $checkParameters, $checkMethods, $checkClasses);
    }

    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $nodeName = null;
        foreach ($this->extractors as $extractor) {
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

    /** @return array<NodeNameExtractor> */
    private function buildExtractors(
        bool $checkVariables,
        bool $checkParameters,
        bool $checkMethods,
        bool $checkClasses
    ): array {
        $extractors = [];

        if ($checkMethods) {
            $extractors[] = new MethodNameExtractor();
        }

        if ($checkParameters) {
            $extractors[] = new ParameterNameExtractor();
        }

        if ($checkClasses) {
            $extractors[] = new ClassNameExtractor();
        }

        if ($checkVariables) {
            $extractors[] = new VariableNameExtractor();
        }

        return $extractors;
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

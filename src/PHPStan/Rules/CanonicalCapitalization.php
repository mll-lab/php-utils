<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use MLL\Utils\PHPStan\NodeNameExtractor\ClassMethodNameExtractor;
use MLL\Utils\PHPStan\NodeNameExtractor\ClassNameExtractor;
use MLL\Utils\PHPStan\NodeNameExtractor\StringNameExtractor;
use MLL\Utils\PHPStan\NodeNameExtractor\VariableNameExtractor;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

use function Safe\preg_match;

/** @implements Rule<Node> */
class CanonicalCapitalization implements Rule
{
    private const CANONICAL_CAPITALIZATIONS = [
        'Lab ID' => [
            'lab id',
            'Lab-ID',
            'LabID ',
            ' LabID',
            ' labID',
            'labID ',
            'LABID',
            'Labid',
            'lab-Id',
            'Lab Id',
        ],
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
            new StringNameExtractor(),
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

        $wrongCapitalization = CanonicalCapitalization::findWrongCapitalization($nodeName);
        if ($wrongCapitalization === null) {
            return [];
        }

        [$correct, $incorrect] = $wrongCapitalization;

        $expectedName = self::fixIDCapitalization($nodeName, $correct, $incorrect);

        return [
            RuleErrorBuilder::message(<<<TXT
                Name of {$node->getType()} "{$nodeName}" should use "{$correct}" instead of "{$incorrect}", rename it to "{$expectedName}".
                TXT)
                ->identifier('mll.canonicalCapitalization')
                ->build(),
        ];
    }

    /** @return array{0: string, 1: string}|null */
    public static function findWrongCapitalization(string $nodeName): ?array
    {
        foreach (self::CANONICAL_CAPITALIZATIONS as $correct => $incorrectVariants) {
            foreach ($incorrectVariants as $incorrect) {
                if (preg_match("/{$incorrect}/", $nodeName) === 1) {
                    return [$correct, $incorrect];
                }
            }
        }

        return null;
    }

    public static function fixIDCapitalization(string $nodeName, string $correct, string $incorrect): string
    {
        $trimmedIncorrect = trim($incorrect);
        $trimmedCorrect = trim($correct);

        return str_replace($trimmedIncorrect, $trimmedCorrect, $nodeName);
    }
}

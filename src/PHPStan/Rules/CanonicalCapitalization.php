<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

use function Safe\preg_match;

/** @implements Rule<Node> */
final class CanonicalCapitalization implements Rule
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
        return Node\Expr\Variable::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $result = NodeIdentifier::extractNodeNameAndType($node);

        if ($node instanceof String_) {
            $result = [$node->value, 'String'];
        }

        if ($result === null) {
            return [];
        }

        [$nodeName, $type] = $result;

        $wrongCapitalization = CanonicalCapitalization::findWrongCapitalization($nodeName);

        if ($wrongCapitalization === null) {
            return [];
        }

        [$correct, $incorrect] = $wrongCapitalization;

        $expectedName = self::fixIDCapitalization($nodeName, $correct, $incorrect);

        return [
            RuleErrorBuilder::message(
                <<<TXT
                {$type} Name "{$nodeName}" should use "{$correct}" instead of "{$incorrect}", rename it to "{$expectedName}".
                TXT
            )->identifier('mllLabRules.nameIdToID')
                ->build(),
        ];
    }

    /** @return array{0: string, 1: string}|null */
    public static function findWrongCapitalization(string $nodeName): ?array
    {
        foreach (self::CANONICAL_CAPITALIZATIONS as $correct => $incorrectVariants) {
            foreach ($incorrectVariants as $incorrect) {
                if (preg_match('/' . $incorrect . '/', $nodeName) === 1) {
                    return [$correct, $incorrect];
                }
            }
        }

        return null;
    }

    public static function fixIDCapitalization(string $nodeName, string $correct, string $incorrect): string
    {
        return str_replace(trim($incorrect), trim($correct), $nodeName);
    }
}

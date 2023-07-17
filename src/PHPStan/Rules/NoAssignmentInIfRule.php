<?php declare(strict_types=1);

namespace MLL\Utils\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\If_;
use PhpParser\NodeFinder;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

/**
 * Inspired by https://github.com/odan/phpstan-rules/blob/388db4cdf7c99e2978f20b1ed8801d748984812a/src/Rules/AssignmentInConditionRule.php.
 *
 * @implements Rule<If_>
 */
class NoAssignmentInIfRule implements Rule
{
    private NodeFinder $nodeFinder;

    public function __construct()
    {
        $this->nodeFinder = new NodeFinder();
    }

    public function getNodeType(): string
    {
        return If_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $assignNode = $this->nodeFinder->findFirstInstanceOf($node->cond, Assign::class);
        if (! $assignNode instanceof Assign) {
            return [];
        }

        return ['Assignment in conditional expression is not allowed.'];
    }
}

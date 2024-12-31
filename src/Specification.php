<?php declare(strict_types=1);

namespace MLL\Utils;

/**
 * Allows the logical combination of specification callables.
 *
 * We define specifications through a functional interface in the form `(mixed): bool`.
 * This allows the usage of ad-hoc closures, first-class callables, and invokable classes.
 *
 * https://en.wikipedia.org/wiki/Specification_pattern
 */
class Specification
{
    /**
     * @template TCandidate
     *
     * @param callable(TCandidate): bool $specification
     *
     * @return callable(TCandidate): bool
     */
    public static function not(callable $specification): callable
    {
        return fn ($value): bool => ! $specification($value);
    }

    /**
     * @template TCandidate
     *
     * @param callable(TCandidate): bool ...$specifications
     *
     * @return callable(TCandidate): bool
     */
    public static function or(callable ...$specifications): callable
    {
        return function ($value) use ($specifications): bool {
            foreach ($specifications as $specification) {
                if ($specification($value)) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * @template TCandidate
     *
     * @param callable(TCandidate): bool ...$specifications
     *
     * @return callable(TCandidate): bool
     */
    public static function and(callable ...$specifications): callable
    {
        return function ($value) use ($specifications): bool {
            foreach ($specifications as $specification) {
                if (! $specification($value)) {
                    return false;
                }
            }

            return true;
        };
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils;

/**
 * Provides a method to look up enum cases by their name property.
 *
 * This trait should only be used with PHP 8.1+ enums.
 *
 * @example
 * enum Status: string
 * {
 *     use TryFromNameTrait;
 *
 *     case PENDING = 'pending';
 *     case ACTIVE = 'active';
 * }
 *
 * Status::tryFromName('PENDING'); // Returns Status::PENDING
 * Status::tryFromName('UNKNOWN'); // Returns null
 */
trait TryFromNameTrait
{
    /**
     * Attempts to find an enum case by its name.
     *
     * @param string $name The case-sensitive name of the enum case
     *
     * @return static|null The matching enum case, or null if not found
     */
    public static function tryFromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }
}

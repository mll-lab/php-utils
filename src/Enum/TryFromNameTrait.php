<?php declare(strict_types=1);

namespace MLL\Utils\Enum;

/**
 * Provides a method to look up enum cases by their name property.
 *
 * This trait must only be used with PHP 8.1+ native enums.
 *
 * @example
 * enum Status
 * {
 *     use TryFromNameTrait;
 *
 *     case PENDING;
 *     case ACTIVE;
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

<?php declare(strict_types=1);

namespace MLL\Utils;

use Illuminate\Support\Str;

final class StringUtil
{
    /**
     * The intention is to limit the length of a name.
     *
     * If it consists of more than one Part e.g. Hans Dieter, it will be abbreviated as: H.D.
     * Unnecessary parts such as "." or "-" are cut out.
     */
    public static function shortenFirstname(string $firstname): string
    {
        if (! self::hasContent($firstname)) {
            return '';
        }

        if (Str::contains($firstname, ' ')) {
            return self::shortenMultiPartName($firstname, ' ');
        }

        if (Str::contains($firstname, '-')) {
            return self::shortenMultiPartName($firstname, '-');
        }

        $amountOfDots = strspn($firstname, '.');
        if ($amountOfDots === 2) {
            /** @var int $dotPosition guaranteed because we know there are two dots */
            $dotPosition = strpos($firstname, '.');

            $firstPart = Str::substr($firstname, 0, 1) . '.';

            $startPos = $dotPosition + 1;
            $secondPart = Str::substr($firstname, $startPos, 1) . '.';

            return $firstPart . ' ' . $secondPart;
        }

        return strtoupper(Str::substr($firstname, 0, 1)) . '.';
    }

    public static function shortenMultiPartName(string $firstname, string $separator): string
    {
        $firstPart = Str::substr($firstname, 0, 1) . '.';

        $afterSeparator = Str::after($firstname, $separator);
        $secondPart = Str::substr($afterSeparator, 0, 1) . '.';

        return $firstPart . $secondPart;
    }

    /**
     * Split a string by line, regardless of which line endings are used.
     *
     * @see https://stackoverflow.com/questions/1483497/how-can-i-put-strings-in-an-array-split-by-new-line
     *
     * @return array<int, string>
     */
    public static function splitLines(string $string): array
    {
        return \Safe\preg_split("/\r\n|\n|\r/", $string);
    }

    public static function normalizeLineEndings(string $input, string $to = "\r\n"): string
    {
        return \Safe\preg_replace("/\r\n|\r|\n/", $to, $input);
    }

    /**
     * Pad a number with leading zero's.
     *
     * @example padNumber(23, 5) -> "00023"
     *
     * @param float|int|string|null $number
     */
    public static function leftPadNumber($number, int $length): string
    {
        if (is_string($number) && ! is_numeric($number)) {
            throw new \InvalidArgumentException("Expected numeric string, got: {$number}");
        }

        return str_pad((string) $number, $length, '0', STR_PAD_LEFT);
    }

    /** Remove forbidden chars (<,>,:,",/,\,|,?,*) from file name. */
    public static function sanitizeFilename(string $fileName): string
    {
        return str_replace(
            [
                '<',
                '>',
                ':',
                '"',
                '/',
                '\\',
                '|',
                '?',
                '*',
            ],
            '',
            $fileName
        );
    }

    /** Does the given string have non-whitespace content? */
    public static function hasContent(?string $maybeString): bool
    {
        if ($maybeString === null) {
            return false;
        }

        return trim($maybeString) !== '';
    }
}

<?php declare(strict_types=1);

namespace MLL\Utils;

use Illuminate\Support\Str;

class StringUtil
{
    /** https://en.wikipedia.org/wiki/Byte_order_mark#UTF-8 */
    public const UTF_8_BOM = "\xEF\xBB\xBF";

    /** https://en.wikipedia.org/wiki/Byte_order_mark#UTF-16 */
    public const UTF_16_BIG_ENDIAN_BOM = "\xFE\xFF";

    /** https://en.wikipedia.org/wiki/Byte_order_mark#UTF-16 */
    public const UTF_16_LITTLE_ENDIAN_BOM = "\xFF\xFE";

    /** https://en.wikipedia.org/wiki/Byte_order_mark#UTF-32 */
    public const UTF_32_BIG_ENDIAN_BOM = "\x00\x00\xFE\xFF";

    /** https://en.wikipedia.org/wiki/Byte_order_mark#UTF-32 */
    public const UTF_32_LITTLE_ENDIAN_BOM = "\xFF\xFE\x00\x00";

    /** @param iterable<string|int|null> $parts */
    public static function joinNonEmpty(string $glue, iterable $parts): string
    {
        $nonEmptyParts = [];
        foreach ($parts as $part) {
            if ($part !== '' && $part !== null) {
                $nonEmptyParts[] = $part;
            }
        }

        return implode($glue, $nonEmptyParts);
    }

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
            /** @var int<0, max> $dotPosition guaranteed because we know there are two dots */
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
        return \Safe\preg_split("/\r\n|\n|\r/", $string); // @phpstan-ignore return.type (preg_split from safe not known)
    }

    public static function normalizeLineEndings(string $input, string $to = "\r\n"): string
    {
        return \Safe\preg_replace("/\r\n|\r|\n/", $to, $input);
    }

    /** Convert string that could be in different UTF encodings (UTF-8, UTF-16BE, ...) to UTF-8. */
    public static function toUTF8(string $string): string
    {
        $encoding = mb_detect_encoding($string, null, true);

        if ($encoding === false) {
            $encoding = self::guessEncoding($string);
        }

        error_clear_last();
        // @phpstan-ignore-next-line \Safe\mb_convert_encoding is not available in older PHP versions
        $converted = mb_convert_encoding($string, 'UTF-8', $encoding);
        // @phpstan-ignore-next-line mb_convert_encoding can return false in older PHP versions
        if (! is_string($converted)) {
            $error = error_get_last();
            $notString = gettype($converted);
            throw new \ErrorException($error['message'] ?? "Expected mb_convert_encoding to return string, got {$notString}.", 0, $error['type'] ?? 1);
        }

        return $converted;
    }

    private static function guessEncoding(string $text): string
    {
        // @see https://www.php.net/manual/en/function.mb-detect-encoding.php#91051
        $first3 = substr($text, 0, 3);
        if ($first3 === self::UTF_8_BOM) {
            return 'UTF-8';
        }

        $first4 = substr($text, 0, 3);
        if ($first4 === self::UTF_32_BIG_ENDIAN_BOM) {
            return 'UTF-32BE';
        }
        if ($first4 === self::UTF_32_LITTLE_ENDIAN_BOM) {
            return 'UTF-32LE';
        }

        $first2 = substr($text, 0, 2);
        if ($first2 === self::UTF_16_BIG_ENDIAN_BOM) {
            return 'UTF-16BE';
        }
        if ($first2 === self::UTF_16_LITTLE_ENDIAN_BOM) {
            return 'UTF-16LE';
        }

        // https://kence.org/2019/11/27/detecting-windows-1252-encoding
        // If the string contains characters in ranges that are either control characters
        // or invalid for ISO-8859-1 or CP-1252, we are unable to reliably guess.
        if (\Safe\preg_match('/[\x00-\x08\x0E-\x1F\x81\x8D\x8F\x90\x9D]/', $text, $matches) !== 0) {
            throw new \Exception("Can not determine UTF encoding of text: {$text}");
        }

        // If we get here, we're going to assume it's either Windows-1252 or ISO-8859-1.
        // If the string contains characters in the ISO-8859-1 reserved range, that's probably Windows-1252.
        if (\Safe\preg_match('/[\x80-\x9F]/', $text) !== 0) {
            return 'Windows-1252';
        }

        // Give up and return ISO-8859-1.
        return 'ISO-8859-1';
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

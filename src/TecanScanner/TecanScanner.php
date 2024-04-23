<?php declare(strict_types=1);

namespace MLL\Utils\TecanScanner;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MLL\Utils\FluidXPlate\FluidXPlate;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\StringUtil;

/**
 * The plate scanner on a tecan worktable.
 */
final class TecanScanner
{
    public const NO_READ = 'NO READ';
    public const RACKID_IDENTIFIER = 'rackid,';

    public static function parseRawContent(string $rawContent): FluidXPlate
    {
        if ($rawContent === '') {
            throw new TecanScanEmptyException();
        }

        $lines = new Collection(StringUtil::splitLines($rawContent));

        $firstLineWithRackID = $lines->shift();

        if (! is_string($firstLineWithRackID) || ! Str::startsWith($firstLineWithRackID, self::RACKID_IDENTIFIER)) {
            throw new NoRackIDException();
        }
        $rackID = Str::substr($firstLineWithRackID, strlen(self::RACKID_IDENTIFIER));

        $expectedCount = FluidXPlate::coordinateSystem()->positionsCount();
        $actualCount = $lines->count();
        if ($expectedCount !== $actualCount) {
            throw new WrongNumberOfWells($expectedCount, $actualCount);
        }

        $plate = new FluidXPlate($rackID);

        foreach ($lines as $line) {
            $barcode = Str::after($line, ',');

            if ($barcode !== self::NO_READ) {
                $coordinatesString = Str::before($line, ',');

                $plate->addWell(
                    Coordinates::fromString(
                        $coordinatesString,
                        $plate::coordinateSystem()
                    ),
                    $barcode
                );
            }
        }

        return $plate;
    }

    /** Checks if a string can be parsed into a FluidXPlate. */
    public static function isValidRawContent(string $rawContent): bool
    {
        $lines = StringUtil::splitLines($rawContent);

        if (count($lines) !== 97) {
            return false;
        }
        if (\Safe\preg_match(/* @lang RegExp */ '/^' . self::RACKID_IDENTIFIER . FluidXPlate::FLUIDX_BARCODE_REGEX_WITHOUT_DELIMITER . '$/', array_shift($lines)) === 0) {
            return false;
        }
        foreach ($lines as $line) {
            if (\Safe\preg_match(/* @lang RegExp */ '/^[A-H][1-12],' . FluidXPlate::FLUIDX_BARCODE_REGEX_WITHOUT_DELIMITER . '|' . self::NO_READ . '$/', $line) !== 1) {
                return false;
            }
        }

        return true;
    }
}

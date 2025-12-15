<?php declare(strict_types=1);

namespace MLL\Utils\Tests;

use Carbon\Carbon;
use MLL\Utils\BavarianHolidays;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class BavarianHolidaysTest extends TestCase
{
    public function testNameHoliday(): void
    {
        self::assertNull(BavarianHolidays::nameHoliday(self::businessDayWednesday()));
        self::assertSame(BavarianHolidays::KARFREITAG, BavarianHolidays::nameHoliday(self::karfreitag2019()));
        self::assertSame(BavarianHolidays::OSTERSONNTAG, BavarianHolidays::nameHoliday(self::easterSunday2019()));
    }

    /** @dataProvider businessDays */
    #[DataProvider('businessDays')]
    public function testBusinessDays(Carbon $businessDay): void
    {
        self::assertTrue(BavarianHolidays::isBusinessDay($businessDay));
        self::assertFalse(BavarianHolidays::isHoliday($businessDay));
    }

    /** @dataProvider holidays */
    #[DataProvider('holidays')]
    public function testHolidays(Carbon $holiday): void
    {
        self::assertFalse(BavarianHolidays::isBusinessDay($holiday));
        self::assertTrue(BavarianHolidays::isHoliday($holiday));
    }

    /** @dataProvider weekend */
    #[DataProvider('weekend')]
    public function testWeekend(Carbon $weekend): void
    {
        self::assertFalse(BavarianHolidays::isBusinessDay($weekend));
        self::assertFalse(BavarianHolidays::isHoliday($weekend));
    }

    public function testAddBusinessDays(): void
    {
        $saturday = self::saturday();
        $mondayAfter = self::saturday()->addDays(2);

        self::assertTrue(
            BavarianHolidays::addBusinessDays($saturday, 1)
                ->isSameDay($mondayAfter),
            'Skips over sunday'
        );
        self::assertTrue(
            $saturday->isSameDay(self::saturday()),
            'Should not mutate the original date'
        );
    }

    public function testSubBusinessDays(): void
    {
        $sunday = self::sunday();
        $thursdayBeforeAllSaints = self::sunday()->subDays(3);
        self::assertTrue(
            BavarianHolidays::subBusinessDays($sunday, 1)
                ->isSameDay($thursdayBeforeAllSaints),
            'Skips over saturday and all saints holiday (01.01.2019)'
        );
        self::assertTrue(
            $sunday->isSameDay(self::sunday()),
            'Should not mutate the original date'
        );
    }

    protected static function businessDayWednesday(): Carbon
    {
        return Carbon::createStrict(2019, 10, 30);
    }

    protected static function karfreitag2019(): Carbon
    {
        return Carbon::createStrict(2019, 4, 19);
    }

    /** Before UNIX timestamps. */
    protected static function easterSunday1969(): Carbon
    {
        return Carbon::createStrict(1969, 4, 6);
    }

    protected static function easterSunday2019(): Carbon
    {
        return Carbon::createStrict(2019, 4, 21);
    }

    protected static function saturday(): Carbon
    {
        return Carbon::createStrict(2019, 11, 2);
    }

    protected static function sunday(): Carbon
    {
        return Carbon::createStrict(2019, 11, 3);
    }

    /** @return iterable<array{Carbon}> */
    public static function businessDays(): iterable
    {
        yield [self::businessDayWednesday()];
    }

    /** @return iterable<array{Carbon}> */
    public static function holidays(): iterable
    {
        yield [self::karfreitag2019()];
        yield [self::easterSunday1969()];
        yield [self::easterSunday2019()];
    }

    /** @return iterable<array{Carbon}> */
    public static function weekend(): iterable
    {
        yield [self::saturday()];
        yield [self::sunday()];
    }

    public function testLoadUserDefinedHolidays(): void
    {
        $yearOfTheTentacle = 2019;
        $dayOfTheTentacle = Carbon::createStrict($yearOfTheTentacle, 8, 22);

        self::assertNull(BavarianHolidays::nameHoliday($dayOfTheTentacle));
        self::assertFalse(BavarianHolidays::isHoliday($dayOfTheTentacle));
        self::assertTrue(BavarianHolidays::isBusinessDay($dayOfTheTentacle));

        $name = 'Day of the Tentacle';
        BavarianHolidays::$loadUserDefinedHolidays = static function (int $year) use ($yearOfTheTentacle, $dayOfTheTentacle, $name): array {
            switch ($year) {
                case $yearOfTheTentacle:
                    return [BavarianHolidays::dayOfTheYear($dayOfTheTentacle) => $name];
                default:
                    self::fail("Expected the year of the passed in date to be passed, got {$year}.");
            }
        };

        self::assertSame($name, BavarianHolidays::nameHoliday($dayOfTheTentacle));
        self::assertTrue(BavarianHolidays::isHoliday($dayOfTheTentacle));
        self::assertFalse(BavarianHolidays::isBusinessDay($dayOfTheTentacle));
    }
}

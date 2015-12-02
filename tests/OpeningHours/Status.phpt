<?php

namespace Cothema\OpeningHours\Test;

use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Status as Tested;
use Nette\Utils\DateTime;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class Status extends \Tester\TestCase {

    private function getOpeningHours1() {
        $openingHours = new OpeningHours;
        $openingHours->setOpeningHours([
            '0' => ['8:00', '20:00'], // Sunday
            '1' => ['15:00', '23:00'], // Monday
            '2' => ['15:00', '23:00'], // Tuesday
            '3' => ['14:00', '23:00'], // Wednesday
            '4' => ['20:00', '24:00'], // Thursday
            '5' => ['10:00', '12:00'], // Friday
            '6' => ['9:00', '16:00'] // Saturday
        ]);
        return new Tested($openingHours);
    }

    private function getOpeningHoursClosingNextDay() {
        $openingHours = new OpeningHours;
        $openingHours->setOpeningHours([
            '0' => ['8:00', '02:00 +1 day'], // Sunday
            '1' => ['15:00', '04:00 +1 day'], // Monday
            '2' => ['15:00', '02:00 +1 day'], // Tuesday
            '3' => ['14:00', '06:00 +1 day'], // Wednesday
            '4' => ['20:00', '08:00 +1 day'], // Thursday
            '5' => ['10:00', '01:00 +1 day'], // Friday
            '6' => ['9:00', '01:00 +1 day'] // Saturday
        ]);
        return new Tested($openingHours);
    }

    public function testCase1() {
        $openingHoursStatus = $this->getOpeningHours1();
        $openingHoursStatus->setTime(new DateTime('2015-12-01 16:00:00')); // Tuesday

        Assert::true($openingHoursStatus->isOpened());
        Assert::false($openingHoursStatus->getClosingAtWarning());
    }

    public function testCase2() {
        $openingHoursStatus = $this->getOpeningHours1();
        $openingHoursStatus->setTime(new DateTime('2015-11-30 11:00:00')); // Monday

        Assert::false($openingHoursStatus->isOpened());
        Assert::false($openingHoursStatus->getClosingAtWarning());
    }

    public function testCase3() {
        $openingHoursStatus = $this->getOpeningHours1();
        $openingHoursStatus->setTime(new DateTime('2015-11-30 21:05:00')); // Monday

        Assert::true($openingHoursStatus->isOpened());
        Assert::truthy($openingHoursStatus->getClosingAtWarning());
    }

    public function testCaseClosingNextDay1() {
        $openingHoursStatus = $this->getOpeningHoursClosingNextDay();

        $openingHoursStatus->setTime(new DateTime('2015-11-30 16:30:00')); // Monday

        Assert::true($openingHoursStatus->isOpened(), '1.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '1.2');

        $openingHoursStatus->setTime(new DateTime('2015-11-30 14:30:00')); // Monday

        Assert::false($openingHoursStatus->isOpened(), '2.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '2.2');
    }

    public function testCaseClosingNextDay2() {
        $openingHoursStatus = $this->getOpeningHoursClosingNextDay();

        $openingHoursStatus->setTime(new DateTime('2015-12-01 01:30:00')); // Tuesday (monday opening hours)

        Assert::true($openingHoursStatus->isOpened(), '1.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '1.2');

        $openingHoursStatus->setTime(new DateTime('2015-12-01 05:30:00')); // Tuesday (monday opening hours)

        Assert::false($openingHoursStatus->isOpened(), '2.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '2.2');
        
        $openingHoursStatus->setTime(new DateTime('2015-12-01 03:30:00')); // Tuesday (monday opening hours)

        Assert::true($openingHoursStatus->isOpened(), '3.1');
        Assert::contains('04:00', $openingHoursStatus->getClosingAtWarning(), '3.2');
    }
}

(new Status)->run();

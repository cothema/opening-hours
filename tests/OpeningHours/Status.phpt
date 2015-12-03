<?php

namespace Cothema\OpeningHours\Test;

use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Status as Tested;
use Nette\Utils\DateTime;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class Status extends \Tester\TestCase {

    private function getEmptyHours() {
        $openingHours = new OpeningHours;
        return new Tested($openingHours);
    }

    private function getOpeningHoursNonstop() {
        $openingHours = new OpeningHours;
        $openingHours->setOpeningHours([
            '0' => TRUE, // Sunday
            '1' => TRUE, // Monday
            '2' => TRUE, // Tuesday
            '3' => TRUE, // Wednesday
            '4' => TRUE, // Thursday
            '5' => TRUE, // Friday
            '6' => TRUE // Saturday
        ]);
        return new Tested($openingHours);
    }
    
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

    private function getOpeningHoursSpecificDay() {
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
        $openingHours->addSpecificDay('2015-12-01', ['10:00', '11:00']); // Thuesday
        $openingHours->addSpecificDay('2015-12-02', FALSE); // Wednesday
        $openingHours->addSpecificDays(['2015-12-03', '2015-12-04'], ['10:00', '11:00']); // Thursday, Friday
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

    public function testCaseClosingSpecificDay() {
        $openingHoursStatus = $this->getOpeningHoursSpecificDay();

        $openingHoursStatus->setTime(new DateTime('2015-12-01 10:30:00'));

        Assert::true($openingHoursStatus->isOpened(), '1.1');
        Assert::truthy($openingHoursStatus->getClosingAtWarning(), '1.2');

        $openingHoursStatus->setTime(new DateTime('2015-12-01 09:30:00'));

        Assert::false($openingHoursStatus->isOpened(), '2.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '2.2');

        $openingHoursStatus->setTime(new DateTime('2015-12-02 05:30:00'));

        Assert::false($openingHoursStatus->isOpened(), '3.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '3.2');

        $openingHoursStatus->setTime(new DateTime('2015-12-02 15:00:00'));

        Assert::false($openingHoursStatus->isOpened(), '4.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '4.2');

        $openingHoursStatus->setTime(new DateTime('2015-12-01 16:00:00'));

        Assert::false($openingHoursStatus->isOpened(), '5.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '5.2');

        $openingHoursStatus->setTime(new DateTime('2015-12-03 16:00:00'));

        Assert::false($openingHoursStatus->isOpened(), '6.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '6.2');

        $openingHoursStatus->setTime(new DateTime('2015-12-04 16:00:00'));

        Assert::false($openingHoursStatus->isOpened(), '7.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '7.2');

        $openingHoursStatus->setTime(new DateTime('2015-12-03 10:30:00'));

        Assert::true($openingHoursStatus->isOpened(), '8.1');
        Assert::truthy($openingHoursStatus->getClosingAtWarning(), '8.2');

        $openingHoursStatus->setTime(new DateTime('2015-12-04 10:30:00'));

        Assert::true($openingHoursStatus->isOpened(), '9.1');
        Assert::truthy($openingHoursStatus->getClosingAtWarning(), '9.2');
    }

    public function testCaseUndefined() {
        $openingHoursStatus = $this->getEmptyHours();

        $openingHoursStatus->setTime(new DateTime('2015-12-01 01:30:00')); // Tuesday

        Assert::false($openingHoursStatus->isOpened(), '1.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '1.2');
    }
    
    public function testCaseOpenedNonstop() {
        $openingHoursStatus = $this->getOpeningHoursNonstop();

        $openingHoursStatus->setTime(new DateTime('2015-12-01 01:30:00')); // Tuesday

        Assert::true($openingHoursStatus->isOpened(), '1.1');
        Assert::false($openingHoursStatus->getClosingAtWarning(), '1.2');
        Assert::true($openingHoursStatus->isOpenedNonstop(), '1.3');
    }
    
    public function testCaseTimeRange1() {
        $openingHoursStatus = $this->getOpeningHoursNonstop();

        $result = $openingHoursStatus->isOpenedByTimeRange(new DateTime('2015-11-28 10:00:00'), new DateTime('2015-12-02 08:00:00'));
        Assert::true($result, '1.1');
    }
    
    public function testCaseTimeRange2() {
        $openingHoursStatus = $this->getEmptyHours();

        $result = $openingHoursStatus->isOpenedByTimeRange(new DateTime('2015-11-28 10:00:00'), new DateTime('2015-12-02 08:00:00'));
        Assert::false($result, '1.1');
    }

}

(new Status)->run();

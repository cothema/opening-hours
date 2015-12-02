<?php

namespace Cothema\OpeningHours\Test;

use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Status as Tested;
use Nette\Utils\DateTime;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class Status extends \Tester\TestCase {

    private $openingHoursStatus;

    private function initOpeningHours1() {
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
        $this->openingHoursStatus = new Tested($openingHours);
    }

    public function testCase1() {
        $this->initOpeningHours1();
        $this->openingHoursStatus->setTime(new DateTime('2015-12-01 16:00:00'));

        Assert::true($this->openingHoursStatus->isOpened());
        Assert::false($this->openingHoursStatus->getClosingAtWarning());
    }

    public function testCase2() {
        $this->initOpeningHours1();
        $this->openingHoursStatus->setTime(new DateTime('2015-11-30 11:00:00'));

        Assert::false($this->openingHoursStatus->isOpened());
        Assert::false($this->openingHoursStatus->getClosingAtWarning());
    }

    public function testCase3() {
        $this->initOpeningHours1();
        $this->openingHoursStatus->setTime(new DateTime('2015-11-30 21:05:00'));

        Assert::true($this->openingHoursStatus->isOpened());
        Assert::truthy($this->openingHoursStatus->getClosingAtWarning());
    }

}

(new Status)->run();

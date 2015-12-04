<?php

namespace Cothema\OpeningHours\Test;

use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Generator\Table as Tested;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

class Table extends \Tester\TestCase {

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
        return $openingHours;
    }

    public function testCase1() {
        $table = new Tested($this->getOpeningHours1());
        $tableArray = $table->getTable()->getLines();

        Assert::same('15:00', $tableArray[0]->getTimeFrom());
        Assert::same('23:00', $tableArray[0]->getTimeTo());
        Assert::same(1, $tableArray[0]->getDayFrom());
        Assert::same(2, $tableArray[0]->getDayTo());
        
        Assert::same('14:00', $tableArray[1]->getTimeFrom());
        Assert::same('23:00', $tableArray[1]->getTimeTo());
    }

}

(new Table)->run();

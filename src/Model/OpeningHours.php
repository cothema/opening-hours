<?php

namespace App\Components\OpeningHours\Model;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class OpeningHours extends \Nette\Object {

    private $openingHours;

    public function __construct() {
        $this->openingHours = [];
    }

    public function getDay($day) {
        return $this->openingHours[(string) $day];
    }
    
    public function getToday() {
        return $this->getDay(date('w'));
    }

    public function setOpeningHours(array $openingHours) {
        foreach($openingHours as $openingHourKey => $openingHour) {
            $weekDay = new WeekDay($openingHourKey);
            $weekDay->setOpenTime($openingHour[0]);
            $weekDay->setCloseTime($openingHour[1]);
            $this->openingHours[(string) $openingHourKey] = $weekDay;
        }
    }

}

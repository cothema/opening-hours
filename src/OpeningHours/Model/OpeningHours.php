<?php

namespace Cothema\OpeningHours\Model;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class OpeningHours extends \Nette\Object {

    /** @var array */
    private $openingHours;

    public function __construct() {
        $this->openingHours = [];
    }

    /**
     * 
     * @param string $day
     * @return WeekDay
     */
    public function getDay($day) {
        return $this->openingHours[(string) $day];
    }
    
    /**
     * 
     * @return WeekDay
     */
    public function getToday() {
        return $this->getDay(date('w'));
    }

    /**
     * 
     * @param array $openingHours
     */
    public function setOpeningHours(array $openingHours) {
        foreach($openingHours as $openingHourKey => $openingHour) {
            $weekDay = new WeekDay($openingHourKey);
            $weekDay->setOpenTime($openingHour[0]);
            $weekDay->setCloseTime($openingHour[1]);
            $this->openingHours[(string) $openingHourKey] = $weekDay;
        }
    }

}

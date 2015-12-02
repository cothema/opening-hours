<?php

namespace Cothema\OpeningHours\Model;

use Nette\Utils\DateTime;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class OpeningHours extends \Nette\Object {

    /** @var array */
    private $openingHours;

    /** @var array */
    private $specificDays;

    public function __construct() {
        $this->openingHours = [];
        $this->specificDays = [];
    }

    /**
     * 
     * @param DateTime $day
     * @return WeekDay
     */
    public function getDay(DateTime $day) {
        if (isset($this->specificDays[$day->format('Y-m-d')])) {
            return $this->specificDays[$day->format('Y-m-d')];
        }

        return $this->openingHours[(string) $day->format('w')];
    }

    /**
     * 
     * @param string $weekDay
     * @return WeekDay
     */
    public function getWeekDay($weekDay) {
        return $this->openingHours[(string) $weekDay];
    }

    /**
     * 
     * @return WeekDay
     */
    public function getToday() {
        return $this->getDay(new DateTime);
    }

    /**
     * 
     * @param array $openingHours
     */
    public function setOpeningHours(array $openingHours) {
        foreach ($openingHours as $openingHourKey => $openingHour) {
            $weekDay = new WeekDay($openingHourKey);
            $weekDay->setOpenTime($openingHour[0]);
            $weekDay->setCloseTime($openingHour[1]);
            $this->openingHours[(string) $openingHourKey] = $weekDay;
        }
    }

    /**
     * 
     * @param string $day e.g. '2015-12-01'
     * @param array|FALSE $openingHours e.g. ['10:00', '11:00']
     */
    public function addSpecificDay($day, $openingHours) {
        $specificDay = new SpecificDay($day);

        if (is_array($openingHours)) {
            $specificDay->setOpenTime($openingHours[0]);
            $specificDay->setCloseTime($openingHours[1]);
        } elseif ($openingHours === FALSE) {
            // Closed all the day
        } else {
            throw new \Exception('Invalid $openingHours param format.');
        }

        $this->specificDays[$day] = $specificDay;
    }

    /**
     * 
     * @param array $days e.g. ['2015-12-01', '2015-12-02']
     * @param array|FALSE $openingHours e.g. ['10:00', '11:00']
     */
    public function addSpecificDays(array $days, $openingHours) {
        foreach ($days as $day) {
            $this->addSpecificDay($day, $openingHours);
        }
    }

    /**
     * 
     * @param string $day e.g. '2015-12-01'
     */
    public function getSpecificDay($day) {
        return isset($this->specificDays[$day]) ? $this->specificDays[$day] : FALSE;
    }

}

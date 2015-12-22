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
     * @param string $day e.g. '2015-12-01'
     * @param array|boolean|string $openingHours e.g. ['10:00', '11:00'] OR FALSE OR 'ByAgreement' OR 'ByAgreementPhone'
     */
    public function addSpecificDay($day, $openingHours) {
        $specificDay = new SpecificDay($day);

        if (is_array($openingHours)) {
            $specificDay->setOpenTime($openingHours[0]);
            $specificDay->setCloseTime($openingHours[1]);
        } elseif ($openingHours === TRUE) {
            $specificDay->setOpenTime('00:00');
            $specificDay->setCloseTime('24:00');
        } elseif ($openingHours === FALSE) {
            // Closed all the day
        } elseif (is_string($openingHours)) {
            // Opened with tags (e.g. by agreement)
            $specificDay->addTagString($openingHours);
            $specificDay->setOpenTime('00:00');
            $specificDay->setCloseTime('24:00');
        } else {
            throw new \Exception('Invalid $openingHours param format.');
        }

        $this->specificDays[$day] = $specificDay;
    }

    /**
     * 
     * @param array $days e.g. ['2015-12-01', '2015-12-02']
     * @param array|boolean $openingHours e.g. ['10:00', '11:00']
     */
    public function addSpecificDays(array $days, $openingHours) {
        foreach ($days as $day) {
            $this->addSpecificDay($day, $openingHours);
        }
    }

    /**
     * 
     * @param integer $nextDays
     * @return array
     */
    public function getSpecificDays($nextDays = 30, $previousDays = 0) {
        $now = new \DateTime;
        return array_filter($this->specificDays, function($val, $key) use ($now, $nextDays, $previousDays) {
            $time = new \DateTime($key);
            $diff = (int) $now->diff($time)->format('%r%a');
            return ($diff >= ($previousDays * -1) && $diff <= $nextDays);
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * 
     * @param integer $nextDays
     * @return boolean
     */
    public function getChangesAvailable($nextDays = 30) {
        return (bool) count($this->getSpecificDays($nextDays));
    }

    /**
     * 
     * @param DateTime|NULL $day
     * @return WeekDay
     */
    public function getDay(DateTime $day) {
        if (isset($this->specificDays[$day->format('Y-m-d')])) {
            return $this->specificDays[$day->format('Y-m-d')];
        } elseif (isset($this->openingHours[(string) $day->format('w')])) {
            return $this->openingHours[(string) $day->format('w')];
        }
        return NULL;
    }

    /**
     * 
     * @param string $day e.g. '2015-12-01'
     */
    public function getSpecificDay($day) {
        return isset($this->specificDays[$day]) ? $this->specificDays[$day] : FALSE;
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
     * @param string $weekDay
     * @return WeekDay
     */
    public function getWeekDay($weekDay) {
        return $this->openingHours[(string) $weekDay];
    }

    /**
     * 
     * @param array $openingHours
     */
    public function setOpeningHours(array $openingHours) {
        foreach ($openingHours as $openingHourKey => $openingHour) {
            $weekDay = new WeekDay($openingHourKey);

            if ($openingHour === TRUE) {
                $weekDay->setOpenTime('00:00');
                $weekDay->setCloseTime('24:00');
            } elseif ($openingHour === FALSE) {
                // Closed all the day
            } else {
                $weekDay->setOpenTime($openingHour[0]);
                $weekDay->setCloseTime($openingHour[1]);
            }

            $this->openingHours[(string) $openingHourKey] = $weekDay;
        }
    }

}

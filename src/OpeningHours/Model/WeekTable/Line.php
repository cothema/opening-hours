<?php

namespace Cothema\OpeningHours\Model\WeekTable;

use Cothema\OpeningHours\Validator;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Line extends \Nette\Object {

    /** @var int */
    private $dayFrom;

    /** @var int */
    private $dayTo;

    /** @var string */
    private $timeFrom;

    /** @var string */
    private $timeTo;

    /**
     * 
     * @return int
     */
    public function getDayFrom() {
        return $this->dayFrom;
    }

    /**
     * 
     * @return int
     */
    public function getDayTo() {
        return $this->dayTo;
    }

    /**
     * 
     * @return string
     */
    public function getTimeFrom() {
        return $this->timeFrom;
    }

    /**
     * 
     * @return string
     */
    public function getTimeTo() {
        return $this->timeTo;
    }

    /**
     * 
     * @param int $dayNum
     */
    public function setDayFrom($dayNum) {
        Validator\WeekDayNumber::validate($dayNum);
        $this->dayFrom = $dayNum;
    }

    /**
     * 
     * @param int $dayNum
     */
    public function setDayTo($dayNum) {
        Validator\WeekDayNumber::validate($dayNum);
        $this->dayTo = $dayNum;
    }

    /**
     * 
     * @param string $time
     */
    public function setTimeFrom($time) {
        $this->timeFrom = $time;
    }

    /**
     * 
     * @param string $time
     */
    public function setTimeTo($time) {
        $this->timeTo = $time;
    }

}

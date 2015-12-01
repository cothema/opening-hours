<?php

namespace App\Components\OpeningHours\Model;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class WeekDay extends \Nette\Object {

    /** @var string */
    private $dayNum;

    /** @var string */
    private $closeTime;

    /** @var string */
    private $openTime;

    /**
     * 
     * @param mixed $dayNum
     */
    public function __construct($dayNum) {
        $this->dayNum = (string) $dayNum;
    }

    /**
     * 
     * @return string
     */
    public function getCloseTime() {
        return $this->closeTime;
    }

    /**
     * 
     * @return string
     */
    public function getOpenTime() {
        return $this->openTime;
    }

    /**
     * 
     * @param string $closeTime e.g. 22:00
     */
    public function setCloseTime($closeTime) {
        $this->closeTime = $closeTime;
    }

    /**
     * 
     * @param string $openTime e.g. 8:00
     */
    public function setOpenTime($openTime) {
        $this->openTime = $openTime;
    }

}

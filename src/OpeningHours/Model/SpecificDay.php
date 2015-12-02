<?php

namespace Cothema\OpeningHours\Model;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class SpecificDay extends \Nette\Object implements I\Day {

    /** @var string */
    private $day;
    
    /** @var string */
    private $closeTime;

    /** @var string */
    private $openTime;

    /**
     * 
     * @param mixed $day YYYY-MM-DD format
     */
    public function __construct($day) {
        $this->day = (string) $day;
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

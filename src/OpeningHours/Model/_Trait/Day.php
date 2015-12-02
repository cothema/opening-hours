<?php

namespace Cothema\OpeningHours\Model\T;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
trait Day {

    /** @var string */
    private $closeTime = FALSE;

    /** @var string */
    private $openTime = FALSE;

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

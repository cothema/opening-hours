<?php

namespace Cothema\OpeningHours\Model\Table;

use Cothema\Time\Validator;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Line extends \Nette\Object {

    /** @var boolean */
    private $active = FALSE;

    /** @var string */
    private $title;

    /** @var string */
    private $timeFrom;

    /** @var string */
    private $timeFromFormatted;

    /** @var string */
    private $timeTo;

    /** @var string */
    private $timeToFormatted;

    /**
     * 
     * @return boolean
     */
    public function getActive() {
        return $this->isActive();
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
    public function getTitle() {
        return $this->title;
    }

    /**
     * 
     * @return string
     */
    public function getTimeFromFormatted() {
        return $this->timeFromFormatted;
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
     * @return string
     */
    public function getTimeToFormatted() {
        return $this->timeToFormatted;
    }

    /**
     * 
     * @return boolean
     */
    public function isActive() {
        return $this->active;
    }

    /**
     * 
     * @param boolean $active
     */
    public function setActive($active = TRUE) {
        Validator\Boolean::validate($active);
        $this->active = $active;
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
    public function setTimeFromFormatted($time) {
        $this->timeFromFormatted = $time;
    }

    /**
     * 
     * @param string $time
     */
    public function setTimeTo($time) {
        $this->timeTo = $time;
    }

    /**
     * 
     * @param string $time
     */
    public function setTimeToFormatted($time) {
        $this->timeToFormatted = $time;
    }

    /**
     * 
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }
    
}

<?php

namespace Cothema\OpeningHours\Model;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class SpecificDay extends \Nette\Object implements I\Day {

    use T\Day;

    /** @var string */
    private $day;
    
    /** @var array */
    private $tags = [];

    /**
     * 
     * @param mixed $day YYYY-MM-DD format
     */
    public function __construct($day) {
        $this->day = (string) $day;
    }

    /**
     * 
     * @return boolean
     */
    public function isActive() {
        return $this->day === date('Y-m-d');
    }

    /**
     * 
     * @return \DateTime
     */
    public function getDay() {
        return new \DateTime($this->day);
    }
    
    /**
     * 
     * @param string $string
     */
    public function addTag($string) {
        $this->tags[] = $string;
    }
    
    /**
     * 
     * @return array
     */
    public function getTags() {
        return $this->tags;
    }

}

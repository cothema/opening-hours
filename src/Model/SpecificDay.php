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

    /**
     * 
     * @param mixed $day YYYY-MM-DD format
     */
    public function __construct($day) {
        $this->day = (string) $day;
    }

}

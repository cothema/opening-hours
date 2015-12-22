<?php

namespace Cothema\OpeningHours\Model;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class WeekDay extends A\Day implements I\Day {

    use T\Day;
    
    /** @var string */
    private $dayNum;

    /**
     * 
     * @param mixed $dayNum
     */
    public function __construct($dayNum) {
        $this->dayNum = (string) $dayNum;
    }

}

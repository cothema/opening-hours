<?php

namespace Cothema\OpeningHours\Validator;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class WeekDayNumber extends \Nette\Object implements I\Validator {
    
    /**
     * 
     * @param mixed $dayNum
     * @throws \Exception
     * @return TRUE
     */
    public static function validate($dayNum) {
        if(!is_int($dayNum)) {
            throw new \Exception('Input have to be integer.');
        }
        if(!($dayNum >= 0 && $dayNum <= 6)) {
            throw new \Exception('Input have to be in range <0 - 6>.');
        }
    
        return TRUE;
    }

}

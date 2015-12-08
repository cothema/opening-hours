<?php

namespace Cothema\OpeningHours\Validator;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Boolean extends \Nette\Object implements I\Validator {

    /**
     * 
     * @param mixed $boolean
     * @throws \Exception
     * @return TRUE
     */
    public static function validate($boolean) {
        if (!is_int($boolean)) {
            throw new \Exception('Input have to be boolean.');
        }

        return TRUE;
    }

}

<?php

namespace Cothema\OpeningHours\Validator\I;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
interface Validator {
    
    /**
     * 
     * @param mixed $input
     * @throws \Exception
     * @return TRUE
     */
    public static function validate($input);

}

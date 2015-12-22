<?php

namespace Cothema\OpeningHours\Tag\A;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
abstract class Tag extends \Nette\Object {
    
    public function __toString() {
        return $this->reflection->name;
    }
    
}

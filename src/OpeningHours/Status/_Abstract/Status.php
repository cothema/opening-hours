<?php

namespace Cothema\OpeningHours\Status\A;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Status extends \Nette\Object {

    private $resolver;
    
    public function setResolver($resolver) {
        $this->resolver = $resolver;
    }
    
    public function getResolver() {
        return $this->resolver;
    }
    
}

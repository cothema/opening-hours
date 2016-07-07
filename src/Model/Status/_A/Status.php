<?php

namespace Cothema\OpeningHours\Model\Status\A;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
abstract class Status extends \Nette\Object {

    use \Cothema\OpeningHours\Model\T\Tags;

    private $resolver;

    public function setResolver($resolver) {
        $this->resolver = $resolver;
    }

    public function getResolver() {
        return $this->resolver;
    }

}

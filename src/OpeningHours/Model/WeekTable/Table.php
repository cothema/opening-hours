<?php

namespace Cothema\OpeningHours\Model\WeekTable;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Table extends \Nette\Object {

    private $lines = [];
    
    public function addLine(Line $line) {
        $this->lines[] = $line;
    }
    
    public function getLines() {
        return $this->lines;
    }
    
}

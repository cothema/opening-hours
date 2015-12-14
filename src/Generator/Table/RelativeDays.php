<?php

namespace Cothema\OpeningHours\Generator\Table;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class RelativeDays extends A\Table {

    private $previousDays = 0;
    private $nextDays = 3;

    protected function generate() {
        
    }

    public function getNextDays() {
        return $this->nextDays;
    }
    
    public function getPreviousDays() {
        return $this->previousDays;
    }

    public function setNextDays($nextDays) {
        $this->nextDays = $nextDays;
    }
    
    public function setPreviousDays($previousDays) {
        $this->previousDays = $previousDays;
    }

}

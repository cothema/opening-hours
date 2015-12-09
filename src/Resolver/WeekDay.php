<?php

namespace Cothema\OpeningHours\Resolver;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class WeekDay extends \Nette\Object {

    /** @var int Day number 0-6 (Sun - Sat) */
    private $dayNumber;

    public function getDayNumber() {
        return $this->dayNumber;
    }

    /**
     * 
     * @param int|string $dayNumber
     * @throws \Exception
     */
    public function setDayNumber($dayNumber) {
        if (is_numeric($dayNumber) && ($dayNumber >= 0 || $dayNumber <= 6)) {
            $this->dayNumber = (int) $dayNumber;
        } else {
            throw new \Exception('Invalid input!');
        }
    }

}

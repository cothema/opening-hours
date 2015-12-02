<?php

namespace Cothema\OpeningHours\Resolver;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class WeekDay extends \Nette\Object {

    /** @var int Day number 0-6 (Sun - Sat) */
    private $day;

    public function getDay() {
        return $this->day;
    }

    /**
     * 
     * @param int|string $day
     * @throws \Exception
     */
    public function setDay($day) {
        if (is_numeric($day) && ($day >= 0 || $day <= 6)) {
            $this->day = (int) $day;
        } else {
            throw new \Exception('Invalid input!');
        }
    }

}

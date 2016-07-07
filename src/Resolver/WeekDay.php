<?php

namespace Cothema\OpeningHours\Resolver;

use Cothema\OpeningHours\Exception\Resolver\InvalidInput;

/**
 * Resolver for week days
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
     * @throws InvalidInput
     */
    public function setDayNumber($dayNumber) {
        if (is_numeric($dayNumber) && ($dayNumber >= 0 || $dayNumber <= 6)) {
            $this->dayNumber = (int) $dayNumber;
        } else {
            throw new InvalidInput(sprintf('Input value "%s" is invalid!', $dayNumber));
        }
    }

}

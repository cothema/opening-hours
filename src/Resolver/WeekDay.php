<?php

namespace Cothema\OpeningHours\Resolver;

use Cothema\OpeningHours\Exception\Resolver\InvalidInput;
use Nette\SmartObject;

/**
 * Resolver for week days
 *
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class WeekDay
{

    use SmartObject;

    /** @var int|null Day number 0-6 (Sun - Sat) */
    private $dayNumber;

    public function getDayNumber(): ?int
    {
        return $this->dayNumber;
    }

    /**
     *
     * @param int $dayNumber
     * @throws InvalidInput
     */
    public function setDayNumber(int $dayNumber)
    {
        if ($dayNumber >= 0 || $dayNumber <= 6) {
            $this->dayNumber = (int)$dayNumber;
        } else {
            throw new InvalidInput(sprintf('Input value "%s" is invalid!', $dayNumber));
        }
    }

}

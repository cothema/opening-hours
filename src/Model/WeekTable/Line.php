<?php

namespace Cothema\OpeningHours\Model\WeekTable;

use Cothema\Time\Validator;

/**
 *
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Line extends \Cothema\OpeningHours\Model\Table\Line
{

    /** @var int */
    private $dayFrom;

    /** @var int */
    private $dayTo;

    /**
     *
     * @return boolean
     */
    public function isAllWeek()
    {
        return ($this->getDayFrom() === 1 && $this->getDayTo() === 0) || ($this->getDayFrom() === 0 && $this->getDayTo() === 6);
    }

    /**
     *
     * @return int
     */
    public function getDayFrom()
    {
        return $this->dayFrom;
    }

    /**
     *
     * @param int $dayNum
     */
    public function setDayFrom($dayNum)
    {
        Validator\WeekDayNumber::validate($dayNum);
        $this->dayFrom = $dayNum;
    }

    /**
     *
     * @return int
     */
    public function getDayTo()
    {
        return $this->dayTo;
    }

    /**
     *
     * @param int $dayNum
     */
    public function setDayTo($dayNum)
    {
        Validator\WeekDayNumber::validate($dayNum);
        $this->dayTo = $dayNum;
    }

}

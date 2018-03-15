<?php

namespace Cothema\OpeningHours\Model;

/**
 *
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class SpecificDay extends A\Day implements I\Day
{

    use T\Day;

    /** @var string */
    private $day;

    /**
     *
     * @param mixed $day YYYY-MM-DD format
     */
    public function __construct($day)
    {
        $this->day = (string)$day;
    }

    /**
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->day === date('Y-m-d');
    }

    /**
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return new \DateTime($this->day);
    }

}

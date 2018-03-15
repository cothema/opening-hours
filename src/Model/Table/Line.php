<?php

namespace Cothema\OpeningHours\Model\Table;

use Cothema\Time\Validator;
use Nette\SmartObject;

/**
 * @property int $active
 * @property int $timeFrom
 * @property int $timeTo
 * @property int $timeFromFormatted
 * @property int $timeToFormatted
 * @property int $title
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Line
{

    use SmartObject;

    /** @var \DateTime */
    public $dateFrom;
    /** @var \DateTime */
    public $dateTo;
    /** @var boolean */
    public $specific;
    /** @var array */
    public $tags = [];
    /** @var boolean */
    private $active = false;
    /** @var string */
    private $title;
    /** @var string */
    private $timeFrom;
    /** @var string */
    private $timeFromFormatted;
    /** @var string */
    private $timeTo;
    /** @var string */
    private $timeToFormatted;

    /**
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->isActive();
    }

    /**
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     *
     * @param boolean $active
     */
    public function setActive($active = true)
    {
        Validator\Boolean::validate($active);
        $this->active = $active;
    }

    /**
     *
     * @return string
     */
    public function getTimeFrom()
    {
        return $this->timeFrom;
    }

    /**
     *
     * @param string $time
     */
    public function setTimeFrom($time)
    {
        $this->timeFrom = $time;
    }

    /**
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     *
     * @return string
     */
    public function getTimeFromFormatted()
    {
        return $this->timeFromFormatted;
    }

    /**
     *
     * @param string $time
     */
    public function setTimeFromFormatted($time)
    {
        $this->timeFromFormatted = $time;
    }

    /**
     *
     * @return string
     */
    public function getTimeTo()
    {
        return $this->timeTo;
    }

    /**
     *
     * @param string $time
     */
    public function setTimeTo($time)
    {
        $this->timeTo = $time;
    }

    /**
     *
     * @return string
     */
    public function getTimeToFormatted()
    {
        return $this->timeToFormatted;
    }

    /**
     *
     * @param string $time
     */
    public function setTimeToFormatted($time)
    {
        $this->timeToFormatted = $time;
    }

}
